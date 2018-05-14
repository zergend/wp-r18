<?php 
// подключаем функцию активации мета блока (my_extra_fields)
add_action('admin_init', 'my_extra_fields', 1);

function my_extra_fields() {
	add_meta_box( 'extra_fields', 'Дополнительные поля', 'extra_fields_box_func', 'post', 'normal', 'high'  );
}

// код блока
function extra_fields_box_func( $post ){
?>
	<p><b>ФОТКИ ДЛЯ ГАЛЕРЕИ </b></p>
	<p>Список ссылок на фотографии (БЕЗ ТЕГОВ!) с Яндекс.Фотки / imgsrc.ru + имя альбома:<br>
		<textarea type="text" name="extra[fotolinks]" style="width:100%;height:150px;"><?php echo get_post_meta($post->ID, 'fotolinks', 1); ?></textarea>
	</p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
}

// включаем обновление полей при сохранении
add_action('save_post', 'my_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_extra_fields_update( $post_id ){
	if( ! wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return false; // если это автосохранение
	if( ! current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['extra']) ) return false;

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map('trim', $_POST['extra']);
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
	}

	return $post_id;
}

?>