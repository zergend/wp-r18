<?php get_header(); ?>

<?php get_sidebar("left"); ?>
  <main>
  <div class="archive  error-404  not-found">
	<header class="archive__page-header">
		<h1 class="archive__page-title"><?php esc_html_e( 'К сожалению, запрашиваемая страница отсутствует', '_s' ); ?></h1>
	</header><!-- .page-header -->

	<div class="error-404__content">
		<p><?php esc_html_e( 'Хотите воспользоваться формой поиска?', '_s' ); ?></p>
    <div class="error-404__search">
  		<?php
  			get_search_form();
      ?>
    </div>
    <p><strong><?php esc_html_e( 'Кроме того, Вы можете использовать другие варианты для поиска нужной информации:', '_s' ); ?></strong></p>
    <div class="error-404__recent_posts">
      <?php
  			the_widget( 'WP_Widget_Recent_Posts' );
  		?>
    </div>

		<div class="error-404__categories">
			<h2 class="error-404__title"><?php esc_html_e( 'Популярные рубрики', '_s' ); ?></h2>
			<ul>
			<?php
				wp_list_categories( array(
					'orderby'    => 'count',
					'order'      => 'DESC',
					'show_count' => 1,
					'title_li'   => '',
					'number'     => 10,
				) );
			?>
			</ul>
		</div><!-- .widget -->
    <div class="error-404__archives">
			<h2 class="error-404__title"><?php esc_html_e( 'Архив записей', '_s' ); ?></h2>
  		<?php
  			/* translators: %1$s: smiley */
  			$archive_content = '<p>Архив записей по месяцам:</p>';
  			the_widget( 'WP_Widget_Archives', array('title' => ' ','count' => true, 'dropdown' => true), "after_title=</h2>$archive_content" );

				//the_widget( 'WP_Widget_Archives', array('title' => 'Архивы','count' => true, 'dropdown' => true) );
      ?>
    </div>
    <div class="error-404__tags">
      <?php
  			the_widget( 'WP_Widget_Tag_Cloud' );
  		?>
    </div>

	</div><!-- .error-404__content -->
</div>
  </main>
</div>
<!-- .wrapper -->

<?php get_footer(); ?>