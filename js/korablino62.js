///// Для СЛАЙДЕРА НА ГЛАВНОЙ /////
// запрашиваем DOM
var links = document.querySelectorAll(".main-slider__btn");
// activeLink обеспечивает метку для активного элемента
var activeLink = 0;

// устанавливаем отслеживание событий
for (var i = 0; i < links.length; i++) {
    var link = links[i];
    link.addEventListener('click', setClickedItem, false);
    // определяем элемент для activeLink
    link.itemID = i;
}

// устанавливаем первый элемент в качестве активного
links[activeLink].classList.add("active");

function setClickedItem(e) {
    removeActiveLinks();
    resetTimer();

    var clickedLink = e.target;
    activeLink = clickedLink.itemID;

    changePosition(clickedLink);
}

function removeActiveLinks() {
    for (var i = 0; i < links.length; i++) {
        links[i].classList.remove("active");
    }
}

// Обработчик изменяет позицию слайдера, после того, как мы убедились,
// что в качестве активной обозначена нужная нам ссылка.
function changePosition(link) {
  link.classList.add("active");
}

//
// Код для автоматической смены слайдов
//
var timeoutID;

function startTimer() {
    // ожидание в течение N секунд перед вызовом goInactive
    timeoutID = window.setInterval(goToNextItem, 7000);
}
startTimer();

function resetTimer() {
    window.clearInterval(timeoutID);
    startTimer();
}

function goToNextItem() {
    removeActiveLinks();

    if (activeLink < links.length - 1) {
        activeLink++;
    } else {
        activeLink = 0;
    }

    var newLink = links[activeLink];
    changePosition(newLink);
}


// Yandex.Metrika counter
(function(d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter21113743 = new Ya.Metrika({
                id: 21113743,
                clickmap: true,
                trackLinks: true,
                accurateTrackBounce: true
            });
        } catch (e) {}
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function() {
            n.parentNode.insertBefore(s, n);
        };
    s.type = "text/javascript";
    s.async = true;
    s.src = "https://mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else {
        f();
    }
})(document, window, "yandex_metrika_callbacks");

// ИНТЕРАКТИВНАЯ КАРТА
ymaps.ready(init);
var myMap,
    myPlacemark;

function init() {
    myMap = new ymaps.Map("yamap", {
        center: [53.878741, 40.041875],
        zoom: 10
    }, {
        searchControlProvider: 'yandex#search'
    });

    myPlacemark = new ymaps.Placemark([53.937935, 40.055608], {
        preset: 'islands#glyphIcon',
        iconGlyph: 'home',
        iconGlyphColor: 'blue',
        hintContent: 'Кораблинский район, Рязанская область',
        balloonContent: 'Кораблинский муниципальный район, Рязанская область'
    });

    myMap.geoObjects.add(myPlacemark);
    myMap.behaviors.disable('scrollZoom');
}
