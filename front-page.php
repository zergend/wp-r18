<?php get_header(); ?>

<div class="front">
<?php get_sidebar("left"); ?>
  <main>
  <?php
    include 'template-parts/content-main-slider.php';
  ?>
    <div class="front__content">
      <section class="front__news">
        <h2>Новости</h2>
        <?php
          include 'template-parts/content-front-news.php';
        ?>
      </section>      

      <section class="front__anounce">
        <h2>Объявления</h2>
        <?php
          include 'template-parts/content-front-anounce.php';
        ?>        
      </section>
    </div>

    <section class="front__service">
      <h2><a href="<?php echo get_category_link($themeoptions['service']); ?>">Наши услуги</a></h2>
      <?php
          include 'template-parts/content-front-service.php';
        ?> 
    </section>
    <section class="front__map">
      <h2>Как нас найти</h2>
        <?php
          include 'template-parts/content-map.php';
        ?> 
    </section>
  </main>
</div>
</div>
<!-- .wrapper -->

<?php get_footer(); ?>