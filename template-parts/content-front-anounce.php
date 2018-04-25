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
	query_posts('cat=' . $themeoptions['anounce'] . '&posts_per_page=' . $themeoptions['countOfAnounce']);   // указываем ID рубрики, которую необходимо вывести и количество постов.
	while (have_posts()) : the_post();
	?>
	<article>
		<div class="front__anounce--title">
			<a href="<?php the_permalink() ?>">
				<?php the_title(); ?>
			</a>
		</div>
		<div class="front__anounce--more">
			<a href="<?php the_permalink() ?>">Далее &nbsp; &rarr;</a>
		</div>
		

	</article>

<?php 
	endwhile;  // завершаем цикл.
	endif;
	/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
	wp_reset_query(); 
?>

	<div class="front__anounce--all">
		<a href="<?php echo get_category_link($themeoptions['anounce']); ?>">Все
		<?php echo get_cat_name($themeoptions['anounce']) ?> &rarr;</a>
	</div>