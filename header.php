<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ГАУ ДО «ДЮСШ «Рекорд»</title>
  <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
  <?php 
    wp_head();
    global $themeoptions; 
  ?>
</head>

<body>
  <div class="wrapper">
    <header>
      <div class="logo">
        <a href="/">
          <img src="<?php echo get_template_directory_uri(); ?>/img/logo.png" alt="Лого">
        </a>
      </div>
      <div class="title">
        <a href="/">
          <h1>Государственное автономное учреждение
            <br>дополнительного образования
            <br>«Детско-юношеская спортивная школа «Рекорд»</h1>
        </a>
      </div>
      <section class="utilities">
        <div class="utilities__search">
          <?php get_search_form(); ?>
        </div>
        <div class="utilities__ftvi">
          <a itemprop="Copy" href="#" class="bt_widget-vi-on" title="Версия для слабовидящих">
            <img src="<?php echo get_template_directory_uri(); ?>/img/ftvi48.png" width="64" height="64" alt="для слабовидящих">
          </a>
        </div>
      </section>

    </header>