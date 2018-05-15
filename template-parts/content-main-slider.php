<div class="main-slider">
  <input type="radio" name="point" id="slide1" class="main-slider__btn" checked>
  <input type="radio" name="point" id="slide2" class="main-slider__btn">
  <input type="radio" name="point" id="slide3" class="main-slider__btn">
  <input type="radio" name="point" id="slide4" class="main-slider__btn">
  <input type="radio" name="point" id="slide5" class="main-slider__btn">

  <div class="main-slider__content">
    <?php				
  if ( have_posts() ) :
  $i = 1;
	query_posts('cat=' . $themeoptions['news'] . '&posts_per_page=5');   // указываем ID рубрики, которую необходимо вывести и количество постов.
	while (have_posts()) : the_post();
    ?>
    <div class="main-slider__item  main-slider__item--<?php echo $i ?>">
      <?php  // миниатюра
        if (function_exists("get_tmb")) {
          $slide = get_tmb( $post->ID, 600, 300, 'src' );
        }
      ?>
      <div class="main-slider__img" style="background-image: url(<?php echo $slide; ?>); ">
        <a href="<?php the_permalink() ?>" class="main-slider__link1">
          
        </a>
      </div>

      <div class="main-slider__info">        
        <h3>
          <a href="<?php the_permalink() ?>" class="main-slider__link2">
            <?php the_title(); ?>
          </a>          
        </h3> 
        <hr>
      </div>      
    </div>

  <?php 
  $i++;
	endwhile;  // завершаем цикл.
  endif;
  
	/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
	wp_reset_query(); 
  ?>
  </div>
  <!-- main-slider__content -->  
  <div class="main-slider__controls  styled-input-container  styled-input--diamond">
    <label for="slide1" class="styled-input-single"></label>
    <label for="slide2" class="styled-input-single"></label>
    <label for="slide3" class="styled-input-single"></label>
    <label for="slide4" class="styled-input-single"></label>
    <label for="slide5" class="styled-input-single"></label>
  </div>
</div>
<!-- main-slider -->