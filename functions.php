<?php
/**
 * rekord18 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rekord18
 */

 // обязательный для темы плагин kama thumbnail
if( ! is_admin() && ! function_exists('kama_thumb_img') ){
	wp_die('Активируйте обязательный для темы плагин Kama Thumbnail');
}

if ( ! function_exists( 'rekord18_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rekord18_setup() {
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	// This theme uses wp_nav_menu() in ... location.
	register_nav_menus( array(
		'header-menu' => 'Меню в шапке',
		'sidebar-menu' => 'Меню в боковой колонке'
	) );
	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rekord18_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'rekord18_setup' );

// включение поддержки форматов постов
add_theme_support( 'post-formats', array('aside', 'gallery', 'image', 'video') );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rekord18_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Левая панель виджетов', 'rekord18' ),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'Добавьте виджеты.', 'rekord18' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Правая панель виджетов', 'rekord18' ),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Добавьте виджеты.', 'rekord18' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Панель виджетов на главной', 'rekord18' ),
		'id'            => 'sidebar-front',
		'description'   => esc_html__( 'Добавьте виджеты.', 'rekord18' ),
		'before_widget' => '<section id="%1$s" class="widget-front-page %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rekord18_widgets_init' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

//////////////////////////////////////////////////////////
remove_action('wp_head','feed_links_extra', 3); // ссылки на дополнительные rss категорий
remove_action('wp_head','feed_links', 2); //ссылки на основной rss и комментарии
remove_action('wp_head','rsd_link');  // для сервиса Really Simple Discovery
remove_action('wp_head','wlwmanifest_link'); // для Windows Live Writer
// add_filter( ‘show_admin_bar’, ‘__return_false’ );
// remove_action('wp_head', '_admin_bar_bump_cb'); // убираем админ-панель
remove_action( 'wp_head', 'wp_resource_hints', 2);
// Отключаем сам REST API
// add_filter('rest_enabled', '__return_false');

 
// Отключаем фильтры REST API
// remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
// remove_action( 'wp_head', 'rest_output_link_wp_head', 10, 0 );
// remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
// remove_action( 'auth_cookie_malformed', 'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_expired', 'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_bad_username', 'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_bad_hash', 'rest_cookie_collect_status' );
// remove_action( 'auth_cookie_valid', 'rest_cookie_collect_status' );
// remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API
// remove_action( 'init', 'rest_api_init' );
// remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
// remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
// remove_action( 'rest_api_init', 'wp_oembed_register_route' );
// remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );


// remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
// remove_action( 'wp_head', 'wp_oembed_add_host_js' );

// убираем разные ссылки при отображении поста - следующая, предыдущая запись, оригинальный url и т.п.
remove_action('wp_head','start_post_rel_link',10,0);
remove_action('wp_head','index_rel_link');
remove_action('wp_head','rel_canonical');
remove_action('wp_head','adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action('wp_head','wp_shortlink_wp_head', 10, 0 );
remove_action('wp_head','wp_generator');  // убирает версию wordpress
function remove_wp_version() {
	return '';
}
add_filter('the_generator', 'remove_wp_version');
/* ----------------------------------------------------------------
 * Отключаем Emojii
 * ---------------------------------------------------------------- */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_wp_emojis_in_tinymce' );
function disable_wp_emojis_in_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

// Убираем "Рубрика:", "Метка:"
add_filter('get_the_archive_title', function( $title ){
	return preg_replace('~^[^:]+: ~', '', $title );
});

////// подключаем дополнительные функции
// функции темы
include('functions/settings.php');
// произвольные поля
// include('functions/my_extra_fields.php');
// menu walkers
include('functions/walker-menu.php');
// Пагинация
include('functions/pagenavi.php');

?>
