$(document).ready(function () {
    const screenWidth = window.screen.width


    if (screenWidth < 785) {
        $('.title_block').click(function () {
            $('.header_card_submenu').slideToggle('slow');
        });
    } else {
        $('.vipbtn-ssil')
            .on('mouseenter', function () {
                $('.header_card_submenu').slideToggle('slow');
            });

        $('.header_card_submenu').on('mouseleave', function () {
            $('.header_card_submenu').slideToggle()
        });
    }
});

//подставляем вместо тэга img тэг svg
$('.img-svg').each(function () {
    var img = $(this);
    var imgClass = img.attr('class');
    var imgUrl = img.attr('src');
    $.get(imgUrl, function (data) {
        var svg = $(data).find('svg');
        if (typeof imgClass !== 'undefined') {
            svg = svg.attr('class', imgClass + ' replaced-svg');
        }
        svg = svg.removeAttr('xmlns:a');
        if (!svg.attr('viewBox') && svg.attr('height') && svg.attr('width')) {
            svg.attr('viewBox', '0 0 ' + svg.attr('height') + ' ' + svg.attr('width'))
        }
        img.replaceWith(svg)
    }, 'xml')
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementsByClassName('calc__price_category')[0].classList.add('price_active');
    document.getElementsByClassName('calc__price_subcategory')[0].classList.add('subcategory_open');


    $('.calc__price_category').click(function () {

        var activeCategory = $('.calc__price_category');
        var activeSubCategory = $('.calc__price_subcategory');

        activeCategory.removeClass('price_active');
        activeCategory.parent().find('.img-svg').removeClass('active_svg');
        activeSubCategory.slideUp();

        $(this).addClass('price_active');
        $(this).siblings('ul').slideDown();
        $(this).parent().find('.img-svg').addClass('active_svg')

        activeSubCategory.removeClass('subcategory_open');
    });

    $('.price-button').click(function () {
        var activeCategory = $('.calc__price_category');
        var activeSubCategory = $('.calc__price_subcategory');

        activeCategory.removeClass('price_active');
        activeCategory.parent().find('.img-svg').removeClass('active_svg');
        activeSubCategory.slideUp();

        var serviceName = $(this).attr('href').substring(1);
        var saerviceClassName =  $('#'+serviceName);
        saerviceClassName.addClass('price_active')
        saerviceClassName.siblings('ul').slideDown();
        saerviceClassName.parent().find('.img-svg').addClass('active_svg')

        activeSubCategory.removeClass('subcategory_open');
    });

});

$(document).ready(function () {
    $('.single-slide').slick({
        slidesToShow: 1,
        infinity: true,
        slidesToScroll: 1,
        adaptiveHeight: true
        // lazyLoad: 'progressive',

    });
})

$('#seo-text-button').on('click', function () {
    $('.seo-text-hide').removeClass('seo-text-hide');
    // $('.seo-text-hide').slideDown();
    $('.seo-text-gradient').remove();
    $('#seo-text-button').remove();
});

//при переходе в подкатегорию, подкатегория становиться первой
let elements = document.getElementsByClassName('price_path');
let pathName = document.location.pathname;

let elementItem = '';
for (let i = 0; i < elements.length; i++) {
    let elem = elements.item(i);

    let el = '';
    let host = window.location.host;

    if (is_host_triple_name(host)) {
        el = elem.getAttribute('href').replace(/https:\/\/[\w]+-[\w]+-[\w]+.[\w]+/g, '');
    } else {
         el = elem.getAttribute('href').replace(/https:\/\/[\w]+-[\w]+.[\w]+/g, '');
    }

    if (pathName.includes(el)) {
        elementItem = elem;
    }
}

if (elementItem) {
    elementItem.className += ' first';
    let subcategoryNodeList = elementItem.parentNode.parentNode.parentNode;
    let subcategoryChildElement = elementItem.parentNode.parentNode;
    subcategoryNodeList.prepend(subcategoryChildElement);
}
//
function is_host_triple_name(hostName) {
    switch (hostName) {
        case 'remont-dizelnogo-dvigatelya.com':
            return true;
        case 'remont-rulevyh-reek.com' :
            return true;
        case 'remont-akpp-moskva.com' :
            return true;
        default:
            return false;
    }
}

