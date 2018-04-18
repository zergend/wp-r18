<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

		<?php
		if ( has_post_thumbnail() ) { // миниатюра
			$img_tmb = get_the_post_thumbnail();
		} else {
			$content = get_the_content();
			$pattern = '/https?.+?\.(jpg|png|JPG)"/';
			$i = preg_match_all($pattern, $content, $matches, PREG_PATTERN_ORDER);

			if ( $i > 0) {
				$large_img = array('_XL.jpg','_L.jpg','_S.jpg','_orig.jpg'); // для замены имени файла на yandex фотках
				$img_tmb = '<img width="300" src="'. str_replace($large_img,'_M.jpg',$matches[0][0]) . '" alt="" class="archive__tmb-image" />';
				} else {
				$img_tmb = '';
				}
		}
			if ($img_tmb != '') {
				// echo '<div class="archive__tmb">';
				echo '<a href="';
				echo the_permalink();
				echo '" rel="bookmark" class="masonry--link">';
				echo $img_tmb;
				the_title( '<h3 class="masonry--title">', '</h3>' );
				echo '</a>';
				// echo '</div>';
			}

		?>
