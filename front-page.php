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
          // get_template_part ( 'template-parts/content', 'front-news' );
        ?>
      </section>      

      <section class="front__anounce">
        <h2>Объявления</h2>
        <?php
          include 'template-parts/content-front-anounce.php';
        ?>        
      </section>
    </div>

    <section class="front__links">
      <h2>Ссылки</h2>
    </section>
  </main>
</div>
</div>
<!-- .wrapper -->

<?php get_footer(); ?>