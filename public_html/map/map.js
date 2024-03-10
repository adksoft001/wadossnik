//Переменная для включения/отключения индикатора загрузки

//Переменная для определения была ли хоть раз загружена Яндекс.Карта (чтобы избежать повторной загрузки при наведении)
var check_if_load = false;


$("#ya-map").mouseover(function () {
    ymap();
    $("#ya-map").parent('section').addClass('showFullMap');
    $("#aside").fadeOut();
});


//Функция создания карты сайта и затем вставки ее в блок с идентификатором "map-yandex"
function init() {

    t = new ymaps.Map("map-yandex", {
        center: [55.753220, 37.622513],
        zoom: 9.5
    });
    var udaltsova = new ymaps.Placemark([55.688228, 37.488502], {
        hintContent: "Техцентр «Моторист»",
        balloonContent: "Москва, ул. Удальцова, 60, к.1",
        iconCaption: "ул. Удальцова, 60, к.1"
    }, {
        preset: 'islands#blueRepairShopIcon',
        iconGlyphColor: 'blue',
    });
    var sevastopolskaya = new ymaps.Placemark([55.634649, 37.543201], {
        hintContent: "Техцентр «Моторист»",
        balloonContent: "Москва, Севастопольский пр. 95 б, к.6",
        iconCaption: "Севастопольский пр. 95 б, к.6"
    }, {
        preset: 'islands#blueRepairShopIcon',
        iconGlyphColor: 'blue'
    });
    var lobnenskaya = new ymaps.Placemark([55.891821, 37.523931], {
        hintContent: "Техцентр «Моторист»",
        balloonContent: "Москва, ул. Лобненская д.17 к.6",
        iconCaption: "ул. Лобненская д.17 к.6",
    }, {
        preset: 'islands#blueRepairShopIcon',
        iconGlyphColor: 'blue'
    });

    var nauchnyi = new ymaps.Placemark([55.65555326950616, 37.55328910779519], {
        hintContent: "Техцентр «Моторист»",
        balloonContent: "Москва, Научный проезд д.14а к.1",
        iconCaption: "Научный проезд д.14а к.1",
    }, {
        preset: 'islands#blueRepairShopIcon',
        iconGlyphColor: 'blue'
    });

    t.geoObjects.add(udaltsova).add(sevastopolskaya).add(lobnenskaya).add(nauchnyi);
}

// Функция для определения полной загрузки карты (на самом деле проверяется загрузка тайлов) 
function waitForTilesLoad(layer) {
    return new ymaps.vow.Promise(function (resolve, reject) {
        var tc = getTileContainer(layer), readyAll = true;
        tc.tiles.each(function (tile, number) {
            if (!tile.isReady()) {
                readyAll = false;
            }
        });
        if (readyAll) {
            resolve();
        } else {
            tc.events.once("ready", function () {
                resolve();
            });
        }
    });
}

function getTileContainer(layer) {
    for (var k in layer) {
        if (layer.hasOwnProperty(k)) {
            if (
                layer[k] instanceof ymaps.layer.tileContainer.CanvasContainer
                || layer[k] instanceof ymaps.layer.tileContainer.DomContainer
            ) {
                return layer[k];
            }
        }
    }
    return null;
}

// Функция загрузки API Яндекс.Карт по требованию (в нашем случае при наведении)
function loadScript(url, callback) {
    var script = document.createElement("script");

    if (script.readyState) {  // IE
        script.onreadystatechange = function () {
            if (script.readyState === "loaded" ||
                script.readyState === "complete") {
                script.onreadystatechange = null;
                callback();
            }
        };
    } else {  // Другие браузеры
        script.onload = function () {
            callback();
        };
    }

    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}

// Основная функция, которая проверяет когда мы навели на блок с классом "ymap-container"
var ymap = function () {

    if (!check_if_load) { // проверяем первый ли раз загружается Яндекс.Карта, если да, то загружаем
        // Чтобы не было повторной загрузки карты, мы изменяем значение переменной
        check_if_load = true;
        // Загружаем API Яндекс.Карт
        loadScript("https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;loadByRequire=1", function () {
            // Как только API Яндекс.Карт загрузились, сразу формируем карту и помещаем в блок с идентификатором "map-yandex"
            ymaps.load(init);
        });
    }

}

