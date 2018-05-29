<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ГАУ ДО «ДЮСШ «Рекорд»</title>
  <link rel="shortcut icon" href="/img/favicon.png" type="image/png">
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter48947690 = new Ya.Metrika({
                    id:48947690,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/48947690" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->  
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
        <div class="utilities__ftvi">
          <a itemprop="Copy" href="#" class="bt_widget-vi-on" title="Версия для слабовидящих">
            <img src="<?php echo get_template_directory_uri(); ?>/img/ftvi48.png" width="64" height="64" alt="для слабовидящих">
          </a>
        </div>        
        <div class="utilities__search">
          <?php get_search_form(); ?>
        </div>
      </section>

    </header>