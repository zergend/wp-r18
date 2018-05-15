<?php
////////////////////////////////////////////
//  Миниатюры из дополнительного поля
//  $id = post_id
//  $w = ширина, $h = высота, $type = что возвращать, img или ссылку на изображение (для background-image)
////////////////////////////////////////////


function get_tmb( $id , $w = 225, $h = 150, $type = 'img' ) {
  $fotolinks = get_post_meta($id, 'fotolinks', true); 
          
if( $fotolinks == '' ){
  if ($type == 'img') {
    echo kama_thumb_img('w=' . $w . ' &h=' . $h . ' &crop=center &allow=any &no_stub');
  } else {
    return kama_thumb_src('w=' . $w . ' &h=' . $h . ' &crop=center &allow=any');
  }
  return true;
}

$pattern = '/http?.+?\.(jpg|png|JPG)/';
					// выберем изображения
					$i = preg_match_all($pattern, $fotolinks, $matches, PREG_PATTERN_ORDER);
	
					if ( $i > 0) {
            if ( $type == 'img' ) {
              echo kama_thumb_img('w=' . $w . ' &h=' . $h . ' &crop=center &allow=any &no_stub', $matches[0][0]);
            } else {
              return kama_thumb_src('w=' . $w . ' &h=' . $h . ' &crop=center &allow=any', $matches[0][0]);
            }
            return true;						
					} else {
            return false;
					}
}

?>
