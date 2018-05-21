    <footer>
      <div class="footer--inside">
        <div class="footer--column-1">
        <p>&copy; <?php echo date('Y') ?> ГАУ ДО «ДЮСШ «Рекорд»</p>
        <p>При полном или частичном использовании материалов ссылка на официальный сайт <a href="/">ГАУ ДО «ДЮСШ «Рекорд»</a> обязательна.</p>  
        <!-- Yandex.Metrika informer -->
        <a href="https://metrika.yandex.ru/stat/?id=48947690&amp;from=informer"
        target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/48947690/3_0_2078C7FF_0058A7FF_1_pageviews"
        style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="48947690" data-lang="ru" /></a>
        <!-- /Yandex.Metrika informer -->
        </div>
        <div class="footer--column-2">

        </div>
        <div class="footer--column-3">

        </div>
        <div class="footer--column-4">
          <p>391200, Рязанская область,<br>
          г. Кораблино, ул. Маяковского, д. 30В</p>
          <div class='links'>
            <a href="https://vk.com/club165047811" title="Группа ГАУ ДО «ДЮСШ «Рекорд» ВКонтакте"><i class="sprite sprite-vk32"></i></a>
            <a href="tel:+74914351776" title="+7 (49143) 5-17-76"><i class="sprite sprite-tel32"></i></a>
            <a href="mailto:fskrekord@mail.ru" title="fskrekord@mail.ru"><i class="sprite sprite-email32"></i></a>
            <a href="http://blogsector.ru" title="Разработка и сопровождение"><i class="sprite sprite-developer32"></i></a>
          </div>
        </div>
      </div>
    </footer>

  <script src="<?php echo get_template_directory_uri();
    if( is_front_page() ){
    echo'/js/rekord.js';
    }
    else {
    echo'/js/rekord.js';
    }
    ?>">
  </script>

  <?php wp_footer(); ?>
  </body>

</html>