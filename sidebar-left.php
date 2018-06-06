  <aside>
    <nav class="menu-vertical  menu-vertical--closed  menu-vertical--nojs">
      <button class="menu-vertical__toggle" type="button">Открыть меню</button>
    <?php

    wp_nav_menu( array( // меню
      'theme_location'  => 'sidebar-menu',
      'menu'            => '',
      'container'       => false,
      'container_class' => '',
      'container_id'    => '',
      'menu_class'      => 'menu-vertical__list',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => false,
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<div class="msg"><ul id="%1$s" class="%2$s">%3$s</ul></div>',
      'depth'           => 0,
      'walker'          => new walker_vertical_nav_menu
    ) );
    ?>
    </nav>

    <nav class="menu-vertical menu-vertical--info  menu-vertical--closed  menu-vertical--nojs">
      <button class="menu-vertical__toggle" type="button">Открыть меню</button>
    <?php

    wp_nav_menu( array( // меню
      'theme_location'  => 'sidebar-menu-info',
      'menu'            => 'Информация',
      'container'       => false,
      'container_class' => '',
      'container_id'    => '',
      'menu_class'      => 'menu-vertical__list',
      'menu_id'         => '',
      'echo'            => true,
      'fallback_cb'     => false,
      'before'          => '',
      'after'           => '',
      'link_before'     => '',
      'link_after'      => '',
      'items_wrap'      => '<h3>Информация</h3><ul id="%1$s" class="%2$s">%3$s</ul>',
      'depth'           => 0,
      'walker'          => new walker_vertical_nav_menu
    ) );
    ?>
    </nav>


    <script>
      var navMain = document.querySelector('.menu-vertical');
      var navToggle = document.querySelector('.menu-vertical__toggle');

      navMain.classList.remove('menu-vertical--nojs');

      navToggle.addEventListener('click', function() {
        if (navMain.classList.contains('menu-vertical--closed')) {
          navMain.classList.remove('menu-vertical--closed');
          navMain.classList.add('menu-vertical--opened');
        } else {
          navMain.classList.add('menu-vertical--closed');
          navMain.classList.remove('menu-vertical--opened');
        }
      });
    </script>

    <div id="first-widget-area" class="widgets">
      <?php dynamic_sidebar( 'sidebar-left' ); ?>
    </div><!-- #first -->

  </aside>
