<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

	<article>
		<div class="archive__news--date">
			<div class="archive__news--day">
				<span class="postdate-tab"><?php the_time('d') ?></span>
			</div>
			<div class="archive__news--month">
				<span class="postdate-tab"><?php the_time('m') ?></span>
			</div>
			<div class="archive__news--year">
				<span class="postdate-tab"><?php the_time('y') ?></span>
			</div>
		</div>
		<div class="archive__news--foto">
			<a href="<?php the_permalink() ?>">
				<?php // миниатюра
					if (function_exists("get_tmb")) {
						get_tmb( $post->ID, 225, 150, 'img' );
					}	
				?>
			</a>
		</div>
		<div class="archive__news--clearfix"></div>
		<div class="archive__news--title">
			<a href="<?php the_permalink() ?>">
				<?php the_title(); ?>
			</a>
			<div class="archive__news--more">
				<a href="<?php the_permalink() ?>">Подробнее &nbsp; &rarr;</a>
			</div>
		</div>

	</article>