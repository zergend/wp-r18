<?php get_header(); ?>

<div class="front single">
<?php get_sidebar("left"); ?>
  <main>
    <?php
      while ( have_posts() ) : the_post();
        get_template_part( 'template-parts/content', 'page' );
      endwhile; // End of the loop.
    ?>
  </main>
</div>
</div>
<!-- .wrapper -->

<?php get_footer(); ?>