<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>

	<?php				
	if ( have_posts() ) :
	query_posts('cat=' . $themeoptions['news'] . '&posts_per_page=' . $themeoptions['countOfNews']);   // указываем ID рубрики, которую необходимо вывести и количество постов.
	while (have_posts()) : the_post();
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
				<?php // миниатюра
					if (function_exists("get_tmb")) {
						get_tmb( $post->ID, 225, 150, 'img' );
					}					
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

<?php 
	endwhile;  // завершаем цикл.
	endif;
	/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
	wp_reset_query(); 
?>

	<div class="front__news--all">
		<a href="<?php echo get_category_link($themeoptions['news']); ?>">Все
		<?php echo get_cat_name($themeoptions['news']) ?> &rarr;</a>
	</div>