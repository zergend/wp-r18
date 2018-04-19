<?php get_header(); ?>

<div class="main-marque">
  <marquee direction="left" onmouseover="this.stop()" onmouseout="this.start()">
    ПРИРОДОПОЛЬЗОВАТЕЛЯМ О ПРЕДОСТАВЛЕНИИ ОТЧЕТОВ ПО ФОРМЕ № 2-ТП (ОТХОДЫ) ... НОВЫЙ ПОРЯДОК ПРИМЕНЕНИЯ КОНТРОЛЬНО – КАССОВОЙ ТЕХНИКИ ... ПОЗДРАВЛЕНИЕ ГЛАВЫ РАЙОНА С ДНЁМ МАТЕРИ ...
  </marquee>
</div>
<main class="main-content">

<?php get_sidebar("left"); ?>

  <div class="column  column--middle">
    <div class="content-block  content-block--full  content-block--sticky content-block--alert">
      <div class="content-block__label">Обратите внимание!</div>
      <?php
				if ( have_posts() ) : // если имеются записи в блоге.
				query_posts('cat=1&posts_per_page=10');   // указываем ID рубрики, которую необходимо вывести и количество постов.

				while (have_posts()) : the_post();  // запускаем цикл обхода материалов блога
				?>
				<p><span class="postdate-tab"><?php the_time('d.m.Y') ?> | </span><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
				<?php
				endwhile;  // завершаем цикл.
				endif;
				/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
				wp_reset_query();
				?>
    </div>

    <div class="content-inner">
      <div class="content-block  content-block--helf  content-block--anounce">
        <div class="content-block__label">Объявления</div>
        <?php
				if ( have_posts() ) : // если имеются записи в блоге.
				query_posts('cat=2&posts_per_page=10');   // указываем ID рубрики, которую необходимо вывести и количество постов.

				while (have_posts()) : the_post();  // запускаем цикл обхода материалов блога
				?>
				<p><span class="postdate-tab"><?php the_time('d.m.Y') ?> | </span><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
				<?php
				endwhile;  // завершаем цикл.
				endif;
				/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
				wp_reset_query();
				?>

      </div>
      <div class="content-block  content-block--helf  content-block--news">
        <div class="content-block__label">Новости</div>
      </div>
    </div>

    <div class="content-block  content-block--full  content-block__video-posts">
      <div class="content-block__label">Видео</div>
      <?php	
				if ( have_posts() ) : // если имеются записи в блоге.
				query_posts('cat=10&posts_per_page=10');   // указываем ID рубрики, которую необходимо вывести и количество постов.

				while (have_posts()) : the_post();  // запускаем цикл обхода материалов блога
				?>
				<p><span class="postdate-tab"><?php the_time('d.m.Y') ?> | </span><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>
				<?php
				endwhile;  // завершаем цикл.
				endif;
				/* Сбрасываем настройки цикла. Если ниже по коду будет идти еще один цикл, чтобы не было сбоя. */
				wp_reset_query();
				?>
    </div>

    <div class="content-block  content-block--full  content-block__gallery">
      <div class="content-block__label">Фотогалерея</div>
    </div>
  </div>

  <?php get_sidebar("right"); ?>

</main>

<?php get_footer(); ?>
