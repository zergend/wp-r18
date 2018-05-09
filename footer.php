    <footer>
      <div class="footer--inside">
        <div class="footer--column-1">

        </div>
        <div class="footer--column-2">

        </div>
        <div class="footer--column-3">

        </div>
        <div class="footer--column-4">
          <p>391200, Рязанская область,<br>
          г. Кораблино, ул. Маяковского, д. 30В</p>
          <p>тел.: +7 (49143) 5-17-75 / 5-17-74</p>
          <p>e-mail: fskrekord@mail.ru</p>
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