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
	query_posts('cat=' . $themeoptions['service'] . '&posts_per_page=' . $themeoptions['countOfService']);   // указываем ID рубрики, которую необходимо вывести и количество постов.
	while (have_posts()) : the_post();
	?>
	<article>
		<div class="front__service--title">		
			<a href="<?php the_permalink() ?>">
				<?php the_title(); ?>
			</a>			
		</div>	
		<div class="front__service--foto">
			<a href="<?php the_permalink() ?>">
				<?php 								
					echo kama_thumb_img('w=280 &h=210 &crop=center');
				?>
			</a>
		</div>	
	</article>

<?php 
	endwhile;  // завершаем цикл.
	endif;
	/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
	wp_reset_query(); 
?>
