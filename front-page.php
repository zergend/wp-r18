<?php get_header(); ?>

<div class="front">
  <aside>
    <?php // get_sidebar("left"); ?>
    <nav>
      <h3>Навигация</h3>
    </nav>
    <div class="widgets">

    </div>
  </aside>
  <main>
    <div class="front__slider">
      <div class="front__slider__img">
        <a href="#">
          <img src="upload/img01.jpg" alt="">
        </a>
      </div>
      <div class="front__slider__info">
        <div class="front__slider__info--title">
          <h3>Заголовок новости 1</h3>
        </div>
        <div class="front__slider__info--toggle">
          <span class="backward">&larr;</span>
          <span class="forward">&rarr;</span>
        </div>
      </div>
    </div>
    <div class="front__content">
      <section class="front__news">
        <h2>Новости</h2>
        <?php
          get_template_part( 'template-parts/content', 'front-news' );
        ?>
      </section>

      <section class="front__anounce">
        <h2>Объявления</h2>
        <article>
          <div class="front__anounce--title">
            <a href="#">Заголовок объявления 1</a>
          </div>
          <div class="front__anounce--more">
            <a href="#">Далее &rarr;</a>
          </div>
        </article>
        <article>
          <div class="front__anounce--title">
            <a href="#">Заголовок объявления 2</a>
          </div>
          <div class="front__anounce--more">
            <a href="#">Далее &rarr;</a>
          </div>
        </article>
        <div class="front__anounce--all">
          <a href="#">Все объявления &rarr;</a>
        </div>
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