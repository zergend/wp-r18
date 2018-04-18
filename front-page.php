<?php get_header(); ?>

<div class="main-marque">
    <?php $CountPost = 10; $CategoryID = $themeoptions['anounce']; ?>
    <?php $my_query = new WP_Query("cat=".$CategoryID."&showposts=".$CountPost);
          while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <p class="main-marque__post"><a href="<?php the_permalink() ?>"><?php the_title(); ?> ...</a></p>
    <?php endwhile; ?>
</div>
<main class="main-content">

<?php get_sidebar("left"); ?>

  <div class="column  column--middle">
    <?php get_template_part( 'template-parts/content', 'main-slider' ); ?>

    <div class="content-block  content-block--full  content-block--sticky content-block--alert">
      <div class="content-block__label content-block__label--alert"><strong>Обратите внимание!</strong></div>

      <?php
      $sticky = get_option('sticky_posts');
      rsort($sticky);
      $sticky = array_slice( $sticky, 0, 7);
      query_posts( array( 'post__in' => $sticky, 'caller_get_posts' => 1 ) );
        while (have_posts()) : the_post();
          get_template_part( 'template-parts/content', 'sticky' );
        endwhile;
      wp_reset_query(); // сброс
      ?>

    </div>

    <div class="content-inner">
      <div class="content-block  content-block--helf  content-block--anounce">
        <div class="content-block__label"><a href="<?php echo get_category_link($themeoptions['anounce']); ?>"><i class="fa fa-info-circle" aria-hidden="true"></i> Объявления >>></a></div>

        <?php
          query_posts('cat='. $themeoptions['anounce'] .'&posts_per_page=5');
            while (have_posts()) : the_post();
              get_template_part( 'template-parts/content', 'title' );
            endwhile;
          wp_reset_query(); // сброс
        ?>

      </div>
      <div class="content-block  content-block--helf  content-block--news">
        <div class="content-block__label"><a href="<?php echo get_category_link($themeoptions['news']); ?>"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Новости >>></a></div>

        <?php
          query_posts('cat='. $themeoptions['news'] .'&posts_per_page=5');
            while (have_posts()) : the_post();
              get_template_part( 'template-parts/content', 'title' );
            endwhile;
          wp_reset_query(); // сброс
        ?>

      </div>
    </div>

    <div class="content-block  content-block--full  content-block__video-posts">
      <div class="content-block__label"><a href="<?php echo get_category_link($themeoptions['video']); ?>"><i class="fa fa-television" aria-hidden="true"></i> Видео >>></a></div>
      <div class="masonry masonry--video">

      <?php
      $args = array(
      	'post_type' => 'post',
        'posts_per_page' => 4,
      	'tax_query' => array(
      		array(
      			'taxonomy' => 'post_format',
      			'field'    => 'slug',
      			'terms' => array( 'post-format-video' )
      		)
      	)
      );
        query_posts($args);
        while (have_posts()) : the_post();
      ?>
        <div class="masonry__item">
      <?php
        get_template_part( 'template-parts/content', 'masonry' );
      ?>
        </div>
      <?php
        endwhile;
        wp_reset_query(); // сброс
      ?>

      </div> <!-- .masonry .masonry--video -->
    </div>

    <div class="content-block  content-block--full  content-block__gallery">
      <div class="content-block__label">
        <i class="fa fa-camera-retro" aria-hidden="true"></i>
          <select name="event-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
           <option value=""><?php echo ' Избранные рубрики'; ?></option>
           <?php
            $args = array ('include' => $themeoptions['gallery'] );
            $categories =  get_categories($args);
            foreach ($categories as $category) {
          	$option = '<option value="/category/archives/'.$category->category_nicename.'">';
          	$option .= $category->cat_name;
          	$option .= ' ('.$category->category_count.')';
          	$option .= '</option>';
          	echo $option;
            }
           ?>
          </select>

        </div>
      <div class="masonry masonry--gallery">

      <?php
      $args = array(
        'post_type' => 'post',
        'posts_per_page' => 8,
        'tax_query' => array(
          array(
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms' => array( 'post-format-gallery' )
          )
        )
      );
        query_posts($args);
        while (have_posts()) : the_post();
      ?>
        <div class="masonry__item masonry__item--gallery">
      <?php
        get_template_part( 'template-parts/content', 'masonry' );
      ?>
        </div>
      <?php
        endwhile;
        wp_reset_query(); // сброс
      ?>

      </div> <!-- .masonry .masonry--gallery -->
    </div>
  </div>

  <?php get_sidebar("right"); ?>

</main>

<?php get_footer(); ?>
