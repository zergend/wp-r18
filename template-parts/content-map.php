<?php
/**
 * Yandex map
 * (код НЕ создан в конструкторе Яндекс.Карты)
 *
 */
?>


<div id="map" style="width: 100%; height: 400px"></div>

<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init);

function init () {
    var myMap = new ymaps.Map("map", {
        // Центр карты, указываем коордианты
        center:[53.925228, 40.042502],
        // Масштаб, тут все просто
        zoom: 16,
        // Отключаем все элементы управления
        // controls: []
    }); 
            
    var myGeoObjects = [];
    
    // Наша метка, указываем коордианты
    myGeoObjects = new ymaps.Placemark([53.925304, 40.043489],{
        balloonContentBody: 'Физкультурно-оздоровительный комплекс</br>'+
					'адрес: г. Кораблино, ул. Маяковского, 30В</br>'+
					'тел.: +7 (49143) 5-17-76</br>'+
					'e-mail: fskrekord@mail.ru</br>'+
					'сайт: <a href="http://rekord.korablino62.ru">rekord.korablino62.ru</a>'
                    },{
                    iconLayout: 'default#image',
                    // Путь до нашей картинки
                    iconImageHref: 'img/rekord-rl-balloon.png', 
                    // Размер по ширине и высоте
                    iconImageSize: [33, 47],
                    // Смещение левого верхнего угла иконки относительно
                    // её «ножки» (точки привязки).
                    iconImageOffset: [-10, -50]
    });
                
    var clusterer = new ymaps.Clusterer({
        clusterDisableClickZoom: false,
        clusterOpenBalloonOnClick: false,
    });
    
    clusterer.add(myGeoObjects);
    myMap.geoObjects.add(clusterer);
    // Отлючаем возможность изменения масштаба
    myMap.behaviors.disable('scrollZoom');

}
</script>    

