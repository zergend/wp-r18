<?php
/**
 * Этот файл можно использовать автономно в темах, для создания миниатюр.
 * Для этого нужно установить настройки в переменную $GLOBALS['kt_opt']
 * version 3.6
 */

// single install or WP plugin?
define( 'IS_KT_WPENV', !! class_exists('Kama_Thumbnail') );

if( ! class_exists('Kama_Thumbnail') ){

	## опции по умолчанию, если класс используется отдельно
	$GLOBALS['kt_opt'] = (object) array(
		// Путь до папки кэша. По умолчанию - server/.../wp-content/cache/thumb.
		'cache_folder'     => wp_normalize_path( WP_CONTENT_DIR . '/cache/thumb'),
		// УРЛ папки кэша. По умолчанию - .../wp-content/cache/thumb
		'cache_folder_url' => content_url() .'/cache/thumb',
		// УРЛ картинки заглушки. По умолчанию - картинка no_photo.jpg, которая лежит рядом с этим файлом
		'no_photo_url'     => str_replace( get_template_directory(), get_template_directory_uri(), wp_normalize_path(dirname(__FILE__)) ) .'/no_photo.jpg',
		// Название произвольного поля
		'meta_key'         => 'photo_URL',
		// Доп. хосты с которых можно создавать мини-ры. Пр.: array('special.ru', 'files.site.ru'). Если указать array('any'), то будут доступны любые хосты.
		'allow_hosts'      => array(),
		// качество сжатия jpg
		'quality'          => 80,
		// не выводить картинку-заглушку
		'no_stub'          => false,
		// режим дебаг
		'debug'            => false,
	);

}


/**
 * Функции обертки для темы/плагина
 *
 * Аргументы: src, post_id, w/width, h/height, q, alt, class, title, no_stub, notcrop.
 * Если не определяется src и переменная $post определяется неправилно, то определяем параметр
 * post_id - идентификатор поста, чтобы правильно получить произвольное поле с картинкой.
 */
## вернет только ссылку
function kama_thumb_src( $args = array(), $src = 'notset' ){
	$kt = new Kama_Make_Thumb( $args, $src );
	return $kt->src();
}

## вернет картинку (готовый тег img)
function kama_thumb_img( $args = array(), $src = 'notset' ){
	$kt = new Kama_Make_Thumb( $args, $src );
	return $kt->img();
}

## вернет ссылку-картинку
function kama_thumb_a_img( $args = array(), $src = 'notset' ){
	$kt = new Kama_Make_Thumb( $args, $src );
	return $kt->a_img();
}

## обращение к последнему экземпляру за свойствами класса: высота, ширина или др...
function kama_thumb( $optname = '' ){
	$instance = Kama_Make_Thumb::$i;

	if( ! $optname ) return $instance;

	if( property_exists( $instance, $optname ) ) return $instance->$optname;
}


class Kama_Make_Thumb {

	public $debug = null; // устанавливается в опциях или здесь...

	public $src;      // str
	public $width;    // int
	public $height;   // int
	public $crop;     // bool/array
	public $quality;  // int/float
	public $post_id;  // int
	public $no_stub;  // bool

	public $notcrop;  // в приоритете над crop
	public $rise_small; // не увеличивать маленькие картинки до указанных размеров. С версии 3.6.

	public $args;
	public $opt;

	protected $thumb_path;
	protected $thumb_url;

	static $i; // последний экземпляр, чтобы был доступ к $width, $height и другим данным...

	function __construct( $args = array(), $src = 'notset' ){

		$this->opt = class_exists('Kama_Thumbnail') ? Kama_Thumbnail::$opt : $GLOBALS['kt_opt'];

		$this->opt->allow_hosts[] = self::parse_main_dom( $_SERVER['HTTP_HOST'] ); // add current main domain

		if( $this->debug === null ) $this->debug = WP_DEBUG && !empty( $this->opt->debug );

		$this->set_args( $args, $src );

		self::$i = $this;
	}

	## Берем ссылку на картинку из произвольного поля, или из текста, создаем произвольное поле.
	## Если в тексте нет картинки, ставим заглушку no_photo
	function get_src_and_set_postmeta(){
		global $post, $wpdb;

		$post_id = (int) ( $this->post_id ? $this->post_id : $post->ID );

		if( $src = get_post_meta( $post_id, $this->opt->meta_key, true ) )
			return $src;

		// проверяем наличие стандартной миниатюры
		if( $_thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true ) )
			$src = wp_get_attachment_url( (int) $_thumbnail_id );

		// получаем ссылку из контента
		if( ! $src ){
			$content = $this->post_id ? $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE ID = ". intval($this->post_id) ." LIMIT 1") : $post->post_content;
			$src = $this->_get_url_from_text( $content );
		}

		// получаем ссылку из вложений - первая картинка
		if( ! $src ){
			$attch_img = get_children( array(
				'numberposts'    => 1,
				'post_mime_type' => 'image',
				'post_parent'    => $post_id,
				'post_type'      => 'attachment'
			) );

			if( $attch_img = array_shift( $attch_img ) )
				$src = wp_get_attachment_url( $attch_img->ID );
		}

		// Заглушка no_photo, чтобы постоянно не проверять
		if( ! $src )
			$src = 'no_photo';

		update_post_meta( $post_id, $this->opt->meta_key, $src );

		return $src;
	}

	## Ссылка из текста
	function _get_url_from_text( $text ){
		$allows = $this->opt->allow_hosts;

		$allows_patt = '';
		if( ! in_array('any', $allows ) ){
			$hosts_regex = implode('|', array_map('preg_quote', $allows ) );
			$allows_patt = '(?:www\.)?(?:'. $hosts_regex .')';
		}

		$hosts_patt = '(?:https?://'. $allows_patt .'|/)';

		if(
			( false !== strpos( $text, 'src=') )
			&&
			preg_match('~(?:<a[^>]+href=[\'"]([^>]+)[\'"][^>]*>)?<img[^>]+src=[\'"]\s*('. $hosts_patt .'.*?)[\'"]~i', $text, $match )
		){
			// проверяем УРЛ ссылки
			$src = $match[1];
			if( ! preg_match('~\.(jpg|jpeg|png|gif)(?:\?.+)?$~i', $src) || ! $this->_is_allow_host($src) ){
				// проверям УРЛ картинки, если не подходит УРЛ ссылки
				$src = $match[2];
				if( ! $this->_is_allow_host($src) )
					$src = '';
			}

			return $src;
		}
	}

	## Проверяем что картинка с доступного хоста
	function _is_allow_host( $url ){
		// pre filter to change the behavior
		if( $return = apply_filters('kama_thumb_is_allow_host', false, $url, $this->opt ) )
			return $return;

		if( ($url{0} === '/' && $url{1} !== '/' ) /*относительный УРЛ*/ || in_array('any', $this->opt->allow_hosts ) )
			return true;

		// get main domain
		$host = self::parse_main_dom( parse_url($url, PHP_URL_HOST) );

		if( $host && in_array( $host, $this->opt->allow_hosts ) )
			return true;

		return false;
	}

	/**
	 * Get main domain name from maybe subdomain: foo.site.com > site.com | sub.site.co.uk > site.co.uk | sub.site.com.ua > site.com.ua
	 * @param  string $host host like: site.ru, site1.site.ru, xn--n1ade.xn--p1ai
	 * @return string Main domain name
	 */
	static function parse_main_dom( $host ){
		// если передан URL
		if( false !== strpos($host, '/') )
			$host = parse_url( $host, PHP_URL_HOST );

		// для http://localhost/foo или IP
		if( ! strpos($host, '.') || filter_var($host, FILTER_VALIDATE_IP) )
			return $host;

		// for cirilic domains: .сайт, .онлайн, .дети, .ком, .орг, .рус, .укр, .москва, .испытание, .бг
		if( false !== strpos($host, 'xn--') )
			preg_match('~xn--[^.]+\.xn--[^.]+$~', $host, $mm );
		else
			preg_match('~[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6}$~', $host, $mm );

		return $mm[0];
	}

	/**
	 * Устанавливает свойства класса width или height, если они неизвестны или не точные (при notcrop).
	 * Данные могут пригодится для добавления в HTML...
	 */
	protected function _checkset_width_height(){

		if( $this->width && $this->height && $this->crop ) return;

		list( $width, $height, $type, $attr ) = getimagesize( $this->thumb_path ); // скорость работы - 2 сек на 50к запросов - быстро

		// не кадрируется и поэтому одна из сторон всегда будет отличаться от указанной...
		if( ! $this->crop ){
			if( $width )  $this->width = $width;
			if( $height ) $this->height = $height;
		}
		// кадрируется, но одна из сторон может быть не указана, проверим и определим есть надо
		else {
			if( ! $this->width )  $this->width  = $width;
			if( ! $this->height ) $this->height = $height;
		}
	}

	/**
	 * Создает миниатюру.
	 *
	 * @return false/str УРЛ миниатюры.
	 */
	function do_thumbnail(){

		// если не передана ссылка, то ищем её в контенте и записываем пр.поле
		if( ! $this->src )
			$this->src = $this->get_src_and_set_postmeta();
		if( ! $this->src )
			return trigger_error('ERROR: No $src prop.', E_USER_NOTICE );

		// проверяем нужна ли картинка заглушка
		if( $this->src == 'no_photo'){
			if( $this->no_stub )
				return false;
			else
				$this->src = $this->opt->no_photo_url;
		}

		// поправим URL
		//$this->src = urldecode( $this->src );          // не обязательно дальше сам декодит...
		$this->src = html_entity_decode( $this->src ); // 'sd&#96;asd.jpg' to 'sd`asd.jpg'

		$path = parse_url( $this->src, PHP_URL_PATH );

		// картинка не определена
		if( ! $path )
			return false;

		preg_match( '~\.([a-z0-9]{2,4})$~i', $path, $m );
		$ext = ! empty($m[1]) ? $m[1] : 'png';

		$_suffix = '';
		if( ! $this->crop && ( $this->height && $this->width ) )
			$_suffix .= '_notcrop';
		if( is_array($this->crop) && preg_match('~top|bottom|left|right~', implode('/', $this->crop), $mm) )
			$_suffix .= "_$mm[0]";
		if( ! $this->rise_small )
			$_suffix .= '_notrise';

		// TODO определять ссылку не по file_exists а по реальному контенту файла.
		// $str = file_get_contents( $file, false, null, 100, 200 );
		// на скорости при этом почти не теряем: file_exists: 0,2 сек и file_get_contents: 0,3 сек на 50к итераций

		// OLD - $file_name      = substr( md5($path), -9 ) ."_{$this->width}x{$this->height}$_suffix.$ext";
		$path_md5         = md5( $path );
		$file_name        = substr( $path_md5, -15 ) ."_{$this->width}x{$this->height}$_suffix.$ext";
		$sub_dir          = substr( $path_md5, -2 );
		$cache_folder     = $this->opt->cache_folder . "/$sub_dir";
		$cache_folder_url = $this->opt->cache_folder_url . "/$sub_dir";
		$this->thumb_path = $cache_folder . "/$file_name";
		$this->thumb_url  = $cache_folder_url ."/$file_name";

		$thumb_url = ''; // готовый URL картинки

		// кэш - если миниатюра уже есть, то возвращаем её
		if( ! $this->debug ){

			$thumb_url = apply_filters_ref_array( 'cached_thumb_url', array( $thumb_url, & $this ) );

			if( ! $thumb_url && file_exists($this->thumb_path) ){
				$thumb_url = $this->thumb_url;
			}

			// если есть заглушка возвращаем её
			if( ! $thumb_url && file_exists( $stub_thumb_path = $this->add_stub_to_path($this->thumb_path) ) ){
				$this->thumb_path = $stub_thumb_path;
				$this->thumb_url = $this->add_stub_to_path( $this->thumb_url );

				if( $this->no_stub )
					return false;

				$thumb_url = $this->thumb_url;
			}

			// Кэш найден. Установим/проверим оригинальные размеры...
			if( $thumb_url ){
				$this->_checkset_width_height();

				return $thumb_url;
			}

		}


		// once ------------------------------------------------------

		$is_no_photo = false;

		if( ! self::_check_create_folder($cache_folder) ){
			if( class_exists('Kama_Thumbnail') ){
				return Kama_Thumbnail::show_message( sprintf( __('Folder where thumbs will be created not exists. Create it manually: "s%"','kama-thumbnail'), $this->opt->cache_folder ), 'error');
			}
			else
				die( 'Kama_Thumbnail: No cache folder. Create it: '. $this->opt->cache_folder );
		}

		if( ! $this->_is_allow_host($this->src) ){
			$this->src   = $this->opt->no_photo_url;
			$is_no_photo = true;
		}

		// УРЛ без протокола: //site.ru/foo
		if( 0 === strpos($this->src, '//') )  $this->src = (is_ssl() ? 'https' : 'http') .":$this->src";
		// относительный УРЛ
		elseif( $this->src{0} == '/' )        $this->src = home_url( $this->src );


		// Если не удалось получить картинку: недоступный хост, файл пропал после переезда или еще чего.
		// То для указаного УРЛ будет создана миниатюра из заглушки no_photo.jpg
		// Чтобы после появления файла, миниатюра создалась правильно, нужно очистить кэш плагина.
		$img_str = $this->get_img_string( $this->src );

		$size = self::_getimagesizefromstring( $img_str );

		if( ! $size || ! isset($size['mime']) || false === strpos( $size['mime'], 'image') ){
			$this->src   = $this->opt->no_photo_url;
			$img_str     = $this->get_img_string( $this->src );
			$is_no_photo = true;
		}

		// Изменим название файла если это картинка заглушка
		if( $is_no_photo ){
			$this->thumb_path = $this->add_stub_to_path( $this->thumb_path );
			$this->thumb_url = $this->add_stub_to_path( $this->thumb_url );
		}

		if( ! $img_str ){
			trigger_error('ERROR: Couldn\'t get img data, even no_photo.', E_USER_NOTICE );
			return false;
		}

		// создаем миниатюру
		// Библиотека Imagick
		if( extension_loaded('imagick') ){
			$this->make_thumbnail_Imagick( $img_str );

			$thumb_url = $this->thumb_url;
		}

		// Библиотека GD
		elseif( extension_loaded('gd') ){
			$this->make_thumbnail_GD( $img_str );

			$thumb_url = $this->thumb_url;
		}
		// нет библиотеки - выборосить заметку
		else
			trigger_error('ERROR: There is no one of the Image libraries (GD or Imagick) installed on your server.', E_USER_NOTICE );

		return $thumb_url;
	}

	/**
	 * Добавляет в конец назыания файла 'stub'
	 * @param  string $path_url Путь до файла или URL файла.
	 * @return string Обработанную строку.
	 */
	function add_stub_to_path( $path_url ){
		$dpath = dirname( dirname( $path_url ) ); // удалим поддиректорию - /3d/
		$bname = basename( $path_url );
		return $dpath . "/stub_$bname";
	}

	## получает реальные параметры картинки
	static function _getimagesizefromstring( $img_data ){
		if( function_exists('getimagesizefromstring') )
			return getimagesizefromstring( $img_data );

		return getimagesize( 'data://application/octet-stream;base64,'. base64_encode($img_data) );
	}

	## проверяем наличие директории, пытаемся создать, если её нет
	static function _check_create_folder( $path ){
		$is = true;
		if( ! is_dir( $path ) ) $is = @ mkdir( $path, 0755, true );

		return $is;
	}

	function get_img_string( $img_url ){
		$imgstring = '';

		if( false === strpos( $img_url, 'http') && '//' !== substr($img_url,0,2)  )
			die('error: IMG url begin with not "http" or "//"');

		// ---- по абсолютному пути
		//if(0) // off
		if( !$imgstring && strpos( $img_url, $_SERVER['HTTP_HOST'] ) ){
			// получим корень сайта $_SERVER['DOCUMENT_ROOT'] может быть неверный
			$root = ABSPATH;

			// maybe WP in sub dir?
			$root_parent = dirname(ABSPATH) .'/';
			if( file_exists( $root_parent . 'wp-config.php') && ! file_exists( $root_parent . 'wp-settings.php' ) ){
				$root = $root_parent;
			}

			$img_path = preg_replace('~^https?://[^/]+/(.*)$~', "$root\\1", $img_url );
			if( file_exists( $img_path ) )
				$imgstring = $this->debug ? file_get_contents( $img_path ) : @ file_get_contents( $img_path );
		}

		// ---- WP HTTP API
		//if(0) // off
		if( !$imgstring && function_exists('wp_remote_get') ){
			$imgstring = wp_remote_retrieve_body( wp_remote_get($img_url) );
		}

		// ---- try ge by URL
		//if(0) // off
		if( !$imgstring && ini_get('allow_url_fopen') ){

			// try find 200 OK. it may be 301, 302 redirects. In 3** redirect first status will be 3** and next 200 ...
			$headers = get_headers( $img_url );
			foreach( $headers as $line ){
				if( false !== strpos( $line, '200 OK' ) ){
					$OK = true;
					break;
				}
			}

			if( !empty($OK) ) $imgstring = file_get_contents( $img_url );
		}

		// ---- curl
		//if(0) // off
		if( !$imgstring && (extension_loaded('curl') || function_exists('curl_version')) ){
			// TODO надо сделать ручной переход по редиректам, а не CURLOPT_FOLLOWLOCATION вроде на некоторых серверах не работает это.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $img_url);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // To make cURL follow a redirect
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Set so curl_exec returns the result instead of outputting it.
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // accept any server certificate, without doing any verification as to which CA signed it, and whether or not that CA is trusted

			$imgstring = curl_exec($ch);

			$errmsg = curl_error($ch);
			$info   = curl_getinfo($ch);
			$OK     = @ $info['http_code'] == 200; //  curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200;

			curl_close($ch);

			if( ! $OK ) $imgstring = '';
		}
		//die( var_dump( $imgstring ? substr($imgstring, 0, 30000) : $imgstring ) );

		return $imgstring; // ''
	}

	## ядро: создание и запись файла-картинки на основе библиотеки Imagick
	protected function make_thumbnail_Imagick( $img_string ){

		$dest = $this->thumb_path;
		$image = new Imagick();
		$image->readImageBlob( $img_string );

		# Select the first frame to handle animated images properly
		if( is_callable( array( $image, 'setIteratorIndex') ) )
			$image->setIteratorIndex(0);

		// устанавливаем качество
		$format = $image->getImageFormat();
		if( $format == 'JPEG' || $format == 'JPG')
			$image->setImageCompression( Imagick::COMPRESSION_JPEG );

		$image->setImageCompressionQuality( $this->quality );

		$origin_h = $image->getImageHeight();
		$origin_w = $image->getImageWidth();

		// получим координаты для считывания с оригинала и размер новой картинки
		list( $dx, $dy, $wsrc, $hsrc, $width, $height ) = $this->_resize_coordinates( $origin_w, $origin_h );

		// обрезаем оригинал
		$image->cropImage( $wsrc, $hsrc, $dx, $dy );
		$image->setImagePage( $wsrc, $hsrc, 0, 0);

		// Strip out unneeded meta data
		$image->stripImage();

		// уменьшаем под размер
		$image->scaleImage( $width, $height );

		$image->writeImage( $dest );
		chmod( $dest, 0755 );
		$image->clear();
		$image->destroy();

		// установим/изменим размеры картинки в свойствах класса, если надо
		$this->_checkset_width_height();
	}

	## ядро: создание и запись файла-картинки на основе библиотеки GD
	protected function make_thumbnail_GD( $img_string ){

		$dest = $this->thumb_path;
		$size = self::_getimagesizefromstring( $img_string );

		if( $size === false )
			return false; // не удалось получить параметры файла;

		list( $origin_w, $origin_h ) = $size;

		$format = strtolower( substr( $size['mime'], strpos($size['mime'], '/')+1 ) );

		// Создаем ресурс картинки
		$image = imagecreatefromstring( $img_string );
		if ( ! is_resource( $image ) )
			return false; // не получилось получить картинку

		// получим координаты для считывания с оригинала и размер новой картинки
		list( $dx, $dy, $wsrc, $hsrc, $width, $height ) = $this->_resize_coordinates( $origin_w, $origin_h );

		// Создаем холст полноцветного изображения
		$thumb = imagecreatetruecolor( $width, $height );

		if( function_exists('imagealphablending') && function_exists('imagesavealpha') ) {
			imagealphablending( $thumb, false ); // режим сопряжения цвета и альфа цвета
			imagesavealpha( $thumb, true ); // флаг сохраняющий прозрачный канал
		}
		if( function_exists('imageantialias') )
			imageantialias( $thumb, true ); // включим функцию сглаживания

		if( ! imagecopyresampled( $thumb, $image, 0, 0, $dx, $dy, $width, $height, $wsrc, $hsrc ) )
			return false; // не удалось изменить размер

		//
		// Сохраняем картинку
		if( $format == 'png'){
			// convert from full colors to index colors, like original PNG.
			if ( function_exists('imageistruecolor') && ! imageistruecolor( $thumb ) ){
				imagetruecolortopalette( $thumb, false, imagecolorstotal( $thumb ) );
			}

			imagepng( $thumb, $dest );
		}
		elseif( $format == 'gif'){
			imagegif( $thumb, $dest );
		}
		else {
			imagejpeg( $thumb, $dest, $this->quality );
		}
		@ chmod( $dest, 0755 );
		imagedestroy($image);
		imagedestroy($thumb);

		// установим/изменим размеры картинки в свойствах класса, если надо
		$this->_checkset_width_height();

		return true;
	}

	# координаты кадрирования
	# $height (необходимая высота), $origin_h (оригинальная высота), $width, $origin_w
	# @return array - отступ по Х и Y и сколько пикселей считывать по высоте и ширине у источника: $dx, $dy, $wsrc, $hsrc
	protected function _resize_coordinates( $origin_w, $origin_h ){

		// если указано не увеличивать картинку и она меньше указанных размеров, укажем максимальный размер - это размер самой картинки
		// важно указать глобальные значения, они юзаются в width и height IMG атрибута и может еще где-то...
		if( ! $this->rise_small ){
			if( $origin_w < $this->width )  $this->width  = $origin_w;
			if( $origin_h < $this->height ) $this->height = $origin_w;
		}

		$crop   = $this->crop;
		$width  = $this->width;
		$height = $this->height;

		// елси не нужно кадрировать и указаны обе стороны, то находим меньшую подходящую сторону у картинки и обнуляем её
		if( ! $crop && ($width > 0 && $height > 0) ){
			if( $width/$origin_w < $height/$origin_h )
				$height = 0;
			else
				$width = 0;
		}

		// если не указана одна из сторон задаем ей пропорциональное значение
		if( ! $width ) 	$width  = round( $origin_w * ($height/$origin_h) );
		if( ! $height ) $height = round( $origin_h * ($width/$origin_w) );

		// определяем необходимость преобразования размера так чтоб вписывалась наименьшая сторона
		// if( $width < $origin_w || $height < $origin_h )
			$ratio = max( $width/$origin_w, $height/$origin_h );

		// определяем позицию кадрирования
		$dx = $dy = 0;
		if( is_array($crop) ){
			$xx = $crop[0];
			$yy = $crop[1];

			// срезать слева и справа
			if( $height/$origin_h > $width/$origin_w ){
				if(0){}
				elseif( $xx === 'center' ) $dx = round( ($origin_w - $width * ($origin_h/$height)) / 2 ); // отступ слева у источника
				elseif( $xx === 'left' )   $dx = 0;
				elseif( $xx === 'right' )  $dx = round( ($origin_w - $width * ($origin_h/$height)) ); // отступ слева у источника
			}
			// срезать верх и низ
			else {
				if(0){}
				elseif( $yy === 'center' ) $dy = round( ($origin_h - $height * ($origin_w/$width)) / 2 );
				elseif( $yy === 'top' )    $dy = 0;
				elseif( $yy === 'bottom' ) $dy = round( ($origin_h - $height * ($origin_w/$width)) );
				// $height*$origin_w/$width)/2*6/10 - отступ сверху у источника *6/10 - чтобы для вертикальных фоток отступ сверху был не половина а процентов 30
			}
		}

		// сколько пикселей считывать c источника
		$wsrc = round( $width/$ratio );
		$hsrc = round( $height/$ratio );

		return array( $dx, $dy, $wsrc, $hsrc, $width, $height );
	}


	## Миниатюры ------------------
	## Обработка параметров для создания миниатюр
	protected function set_args( $args = array(), $src = 'notset' ){

		// все параметры без алиасов
		$def = array(
			//'notcrop'   => '',  // detects by isset()
			//'no_stub'   => '',  // detects by isset()
			//'yes_stub'  => '',  // detects by isset()
			'allow'       => '',  // разрешенные хосты для этого запроса, чтобы не указывать настройку глобально
			'width'       => '',  // пропорционально
			'height'      => '',  // пропорционально
			'attach_id'   => is_numeric($src) ? intval($src) : 0,
						   // ID изображения (вложения) в структуре WordPress.
						   // Этот ID можно еще указать числом в параметре src или во втором параметре функции kama_thumb_*()
			'src'         => $src, // алиасы 'url', 'link', 'img'
			'quality'     => $this->opt->quality,
			'post_id'     => '', // алиас 'post'

			'rise_small'  => $this->opt->rise_small, // увеличивать ли изображения, если они меньше указанных размеров. По умолчанию: true.
			'crop'        => true, // чтобы отключить кадрирование, укажите: 'false/0/no/none' или определите параметр 'notcrop'.
								 // можно указать строку: 'right/bottom' или 'top', 'bottom', 'left', 'right', 'center' и любые их комбинации.
								 // это укажет область кадрирования:
								 // 'left', 'right' - для горизонтали
								 // 'top', 'bottom' - для вертикали
								 // 'center' - для обоих сторон
								 // когда указывается одно значение, второе будет по умолчанию. По умолчанию 'center/center'
			// атрибуты тегов IMG и A
			'class'     => 'aligncenter',
			'style'     => '',
			'alt'       => '',
			'title'     => '',
			'attr'      => '', // произвольная строка, вставляется как есть

			'a_class'   => '',
			'a_style'   => '',
			'a_attr'    => '',
		);

		if( is_string( $args ) ){
			// parse_str превращает пробелы в "_", например тут "w=230 &h=250 &notcrop &class=aligncenter" notcrop будет notcrop_
			$args = preg_replace( '~ +&~', '&', trim($args) );
			parse_str( $args, $rg );
		}
		else
			$rg = $args;

		$rg = array_merge( $def, $rg );

		foreach( $rg as & $val ){
			if( is_string($val) ) $val = trim( $val );
		}
		unset($val);

		// алиасы параметров
		if( isset($rg['w']) )           $rg['width']   = $rg['w'];
		if( isset($rg['h']) )           $rg['height']  = $rg['h'];
		if( isset($rg['q']) )           $rg['quality'] = $rg['q'];
		if( isset($rg['post']) )        $rg['post_id'] = $rg['post'];
		if( is_object($rg['post_id']) ) $rg['post_id'] = $rg['post_id']->ID; // если в post_id передан объект поста
		if( isset($rg['url']) )         $rg['src']     = $rg['url'];
		elseif( isset($rg['link']) )    $rg['src']     = $rg['link'];
		elseif( isset($rg['img']) )     $rg['src']     = $rg['img'];
		if( $rg['attach_id'] && $atch_id = wp_get_attachment_url($rg['attach_id']) ) $rg['src'] = $atch_id;
		if( in_array($rg['crop'], array('no','none'), true) ) $rg['crop'] = false;

		// если src не указан - обнулим. Если указан и передано пустое значение - 'no_photo'
		// для случаев, когда в src указано: ''/null/false...
		if( $rg['src'] === 'notset' ) $rg['src'] = '';
		elseif( empty($rg['src']) )   $rg['src'] = 'no_photo';

		// установим свойства
		$this->src        = (string) $rg['src'];
		$this->width      = (int)    $rg['width'];
		$this->height     = (int)    $rg['height'];
		$this->quality    = (int)    $rg['quality'];
		$this->post_id    = (int)    $rg['post_id'];

		$this->notcrop    = isset($rg['notcrop']); // до $this->crop
		$this->crop       = $this->notcrop ? false : $rg['crop'];
		$this->rise_small = !! $rg['rise_small'];
//die( print_r(  $this  ) );

		// размер миниатюр по умолчанию
		if( ! $this->width && ! $this->height ) $this->width = $this->height = 100;

		// кадрирование не имеет смысла если одна из сторон равна 0 - она всегда будет подограна пропорционально...
		if( ! $this->height || ! $this->width ) $this->crop = false;

		// превратим crop в массив, проверим параметры и дополним недостающие
		if( $this->crop ){

			if( in_array($this->crop, array(true, 1, '1'), true) ){
				$this->crop = array('center','center');
			}
			else {
				if( is_string($this->crop) )  $this->crop = preg_split('~[/,: -]~', $this->crop ); // top/right
				if( ! is_array($this->crop) ) $this->crop = array();

				$xx = & $this->crop[0];
				$yy = & $this->crop[1];

				// поправим если неправильно указаны оси...
				if( in_array($xx, array('top','bottom')) ){ $this->crop[1] = $xx; $this->crop[0] = 'center'; }
				if( in_array($yy, array('left','right')) ){ $this->crop[0] = $yy; $this->crop[1] = 'center'; }

				if( ! $xx || ! in_array($xx, array('left','center','right')) ) $xx = 'center';
				if( ! $yy || ! in_array($yy, array('top','center','bottom')) ) $yy = 'center';
			}
		}


		if( isset($rg['yes_stub']) )
			$this->no_stub = false;
		else
			$this->no_stub = ( isset($rg['no_stub']) || !empty($this->opt->no_stub) );

		// добавим разрешенные хосты
		if( $rg['allow'] ){
			foreach( preg_split('~[, ]+~', $rg['allow'] ) as $host )
				$this->opt->allow_hosts[] = ($host==='any') ? $host : self::parse_main_dom($host);
		}

		$this->args = apply_filters('kama_thumb_set_args', $rg );
	}

	function src(){
		return $this->do_thumbnail();
	}

	function img(){
		if( ! $src = $this->src() ) return '';

		$rg = & $this->args; // упростим

		if( ! $rg['alt'] && $rg['title'] ) $rg['alt'] = $rg['title'];

		$attr  = array();

		// width height на этот момент всегда точные!
		$attr[] = 'width="'. intval($this->width) .'" height="'. intval($this->height) .'"';
		$attr[] = 'alt="'. ($rg['alt'] ? esc_attr($rg['alt']) : '') .'"';

		if( $rg['title'] ) $attr[] = 'title="'. esc_attr( $rg['title'] ) .'"';
		if( $rg['class'] ) $attr[] = 'class="'. preg_replace('/[^A-Za-z0-9 _-]/', '', $rg['class'] ) .'"';
		if( $rg['style'] ) $attr[] = 'style="'. strip_tags($rg['style']) .'"';
		if( $rg['attr'] )  $attr[] = $rg['attr'];

		$out = '<img src="'. esc_url($src) .'" '. implode(' ', $attr) .'>';

		return apply_filters('kama_thumb_img', $out, $rg );
	}

	function a_img(){
		if( ! $img = $this->img() ) return '';

		$rg = & $this->args; // упростим

		$attr  = array();
		if( $rg['a_class'] ) $attr[] = 'class="'. preg_replace('/[^A-Za-z0-9 _-]/', '', $rg['a_class'] ) .'"';
		if( $rg['a_style'] ) $attr[] = 'style="'. strip_tags($rg['a_style']) .'"';
		if( $rg['a_attr'] )  $attr[] = $rg['a_attr'];

		$out = '<a href="'. esc_url($this->src) .'"'.( $attr ? ' '.implode(' ', $attr) : '' ).'>'. $img .'</a>';
		return apply_filters('kama_thumb_a_img', $out );
	}
	## / Миниатюры ------------------

}

