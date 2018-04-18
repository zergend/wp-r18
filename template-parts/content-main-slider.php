<div class="main-slider">
  <?php
  $args = array('posts_per_page' => 30,
                'ignore_sticky_posts' => 1);
  $query = new WP_Query( $args );
  $i = 0;
  $img = array('','','','','');
  $title = array('','','','','');
  $link = array('','','','','');
  ?>
  <?php  while ($query->have_posts()) : $query->the_post();
  $content = get_the_content();
  $pattern = '/https?.+?\.(jpg|png|JPG)"/';
  $match = preg_match_all($pattern, $content, $matches, PREG_PATTERN_ORDER);

  if ( $match > 0) {
    $large_img = array('_orig.jpg','_L.jpg','_S.jpg','_M.jpg'); // для замены имени файла на yandex фотках
    $img[$i] = str_replace($large_img,'_XL.jpg',$matches[0][0]);
    $title[$i] = the_title( '<a href="' . esc_url( get_permalink() ) . '" class="main-slider__link2" rel="bookmark">', '</a>', false );
    $link[$i] = esc_url( get_permalink() );
    $i++;
    } else {
    //$img[$i] = '';
    }

    if ( $i > 4 ) {
      break;
    }
    endwhile;
  wp_reset_query(); // сброс
  ?>

  <input type="radio" name="point" id="slide1" class="main-slider__btn" checked>
  <input type="radio" name="point" id="slide2" class="main-slider__btn">
  <input type="radio" name="point" id="slide3" class="main-slider__btn">
  <input type="radio" name="point" id="slide4" class="main-slider__btn">
  <input type="radio" name="point" id="slide5" class="main-slider__btn">
  <div class="main-slider__content">
    <div class="main-slider__item  main-slider__item--1" style="background-image: url(<?php echo $img[0]; ?>); background-position: center; ">
      <a href="<?php echo $link[0]; ?>" class="main-slider__link1"></a>
      <?php echo $title[0]; ?>
    </div>
    <div class="main-slider__item  main-slider__item--2" style="background-image: url(<?php echo $img[1]; ?>); background-position: center; ">
      <a href="<?php echo $link[1]; ?>" class="main-slider__link1"></a>
      <?php echo $title[1]; ?>
    </div>
    <div class="main-slider__item  main-slider__item--3" style="background-image: url(<?php echo $img[2]; ?>); background-position: center; ">
      <a href="<?php echo $link[2]; ?>" class="main-slider__link1"></a>
      <?php echo $title[2]; ?>
    </div>
    <div class="main-slider__item  main-slider__item--4" style="background-image: url(<?php echo $img[3]; ?>); background-position: center; ">
      <a href="<?php echo $link[3]; ?>" class="main-slider__link1"></a>
      <?php echo $title[3]; ?>
    </div>
    <div class="main-slider__item  main-slider__item--5" style="background-image: url(<?php echo $img[4]; ?>); background-position: center; ">
      <a href="<?php echo $link[4]; ?>" class="main-slider__link1"></a>
      <?php echo $title[4]; ?>
    </div>
  </div>
  <div class="main-slider__controls">
    <label for="slide1"></label>
    <label for="slide2"></label>
    <label for="slide3"></label>
    <label for="slide4"></label>
    <label for="slide5"></label>
  </div>
</div>
