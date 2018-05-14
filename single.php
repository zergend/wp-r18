<?php get_header(); ?>

<div class="front single">
<?php get_sidebar("left"); ?>
  <main>
  <?php
    while ( have_posts() ) : the_post();
      $format_post = get_post_format();
      switch ($format_post) {
        case "gallery":
          get_template_part( 'template-parts/content', 'single-gallery' );
          break;
        case "video":
          get_template_part( 'template-parts/content', 'video' );
          break;
        case "image":
          get_template_part( 'template-parts/content', 'image' );
          break;
        case "aside":
          
          break;
        default:
          get_template_part( 'template-parts/content', 'single' );
      }
  		endwhile; // End of the loop.
    ?>
    <div class="single__end">
		  <img width="300" src="<?php echo get_template_directory_uri(); ?>/img/end-of-single.png" alt="">
    </div>
  </main>
</div>
</div>
<!-- .wrapper -->

<?php get_footer(); ?>