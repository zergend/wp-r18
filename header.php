<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ГАУ ДО «ДЮСШ «Рекорд»</title>
  <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,400i,700&amp;subset=cyrillic" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,700&amp;subset=cyrillic" rel="stylesheet">
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css" />
  <!--[if IE]>
  <link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/ie-only.css" />
  <![endif]-->
  <?php
  if( is_singular($post_types) ) {
    echo "<script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js?ver=4.7'></script>";
  // fotorama.css & fotorama.js
    echo '<link  href="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">';
    echo '<script src="http://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>';
  }
  ?>

    <?php wp_head();
  global $themeoptions; ?>
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
        <div class="utilities__ftvi">
          <a href="#">ftvi</a>
        </div>
        <div class="utilities__search">
          <a href="#">Поиск</a>
        </div>
      </section>

    </header>