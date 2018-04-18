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
