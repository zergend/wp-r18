<?php get_header(); ?>

<div class="archive">
<?php get_sidebar("left"); ?>
  <main>
    <header class="archive__page-header">
      <?php
        the_archive_title( '<h1 class="archive__title">', '</h1>' );
        the_archive_description( '<div class="archive__title--description">', '</div>' );
      ?>
    </header><!-- .page-header -->    
  <?php
    while ( have_posts() ) : the_post();
      get_template_part( 'template-parts/content', 'archive' );
    endwhile; // End of the loop.
    // the_posts_navigation();
    if (function_exists("kama_pagenavi")) :
      kama_pagenavi();
    endif;
		?>
  </main>
</div>
</div>
<!-- .wrapper -->

<?php get_footer(); ?>