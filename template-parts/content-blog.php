<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

	<article>
		<div class="front__news--date">
			<div class="front__news--day">
				<span class="postdate-tab"><?php the_time('d') ?></span>
			</div>
			<div class="front__news--month">
				<span class="postdate-tab"><?php the_time('m') ?></span>
			</div>
			<div class="front__news--year">
				<span class="postdate-tab"><?php the_time('y') ?></span>
			</div>
		</div>
		<div class="front__news--foto  size-tmb-225x150">
			<a href="<?php the_permalink() ?>">
				<?php 								
					echo kama_thumb_img('w=225 &h=150 &crop=center');
				?>
			</a>
		</div>
		<div class="front__news--title">
			<a href="<?php the_permalink() ?>">
				<?php the_title(); ?>
			</a>
			<div class="front__news--more">
				<a href="<?php the_permalink() ?>">Подробнее &nbsp; &rarr;</a>
			</div>
		</div>

	</article>