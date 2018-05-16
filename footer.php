    <footer>
      <div class="footer--inside">
        <div class="footer--column-1">
        <p>&copy; <?php echo date('Y') ?> ГАУ ДО «ДЮСШ «Рекорд»</p>
        <p>При полном или частичном использовании материалов ссылка на официальный сайт <a href="/">ГАУ ДО «ДЮСШ «Рекорд»</a> обязательна.</p>  
        </div>
        <div class="footer--column-2">

        </div>
        <div class="footer--column-3">

        </div>
        <div class="footer--column-4">
          <p>391200, Рязанская область,<br>
          г. Кораблино, ул. Маяковского, д. 30В</p>
          <div class='links'>            
            <span class='vk'><a href="https://vk.com/club165047811" title="Группа ГАУ ДО «ДЮСШ «Рекорд» ВКонтакте"><img src="<?php echo get_template_directory_uri(); ?>/img/vk32.png" alt="ВКонтакте"></a></span>
            <span class='tel'><a href="tel:+74914351776" title="+7 (49143) 5-17-76"><img src="<?php echo get_template_directory_uri(); ?>/img/tel32.png" alt="Телефон"></a></span>
            <span class='email'><a href="mailto:fskrekord@mail.ru" title="fskrekord@mail.ru"><img src="<?php echo get_template_directory_uri(); ?>/img/email32.png" alt="Эл.почта"></a></span>
            <span class='developer'><a href="http://blogsector.ru" title="Разработка и сопровождение"><img src="<?php echo get_template_directory_uri(); ?>/img/developer32.png" alt="Разработчик"></a></span>
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