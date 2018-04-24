<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 */
?>



	<?php				
	if ( have_posts() ) : // если имеются записи в блоге.
	query_posts('cat=' . $themeoptions['news'] . '&posts_per_page=' . $themeoptions['countOfNews']);   // указываем ID рубрики, которую необходимо вывести и количество постов.
	while (have_posts()) : the_post();  // запускаем цикл обхода материалов блога
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
			<?php 
				// if ( has_post_thumbnail() ) { // миниатюра			
				echo kama_thumb_img('w=225 &h=150 &crop=center');
				// }
			?>
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
		<?php echo get_cat_name($themeoptions['news']) ?> &raquo;</a>
	</div>