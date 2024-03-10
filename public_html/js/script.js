//раскрывающийся аккардеон
!function (t) {
    var o, n;
    $('.title_block').unbind();
    t(".title_block").on("click", function () {
        o = t(this).parents(".accordion_item"), n = o.find(".info"),
            o.hasClass("active_block") ? (o.removeClass("active_block"),
                n.slideUp()) : (o.addClass("active_block"), n.stop(!0, !0).slideDown(),
                o.siblings(".active_block").removeClass("active_block").children(
                    ".info").stop(!0, !0).slideUp())
    })
}(jQuery);

//Вызываем или закрываем 2 версии мобильного меню

$('.mobmenu-open').click(function (event) {
    $('.menu-ten').slideToggle(500);
    $('.header-center-menu').slideToggle(500);
});
$('.menu-ten').click(function (event) {
    $('.menu-ten').slideToggle(500);
    $('.header-center-menu').slideToggle(500);
});
$('.mobmenu-close').click(function (event) {
    $('.menu-ten').slideToggle(500);
    $('.header-center-menu').slideToggle(500);
});

$('.addr-open').click(function (event) {
    $('.header-addrw').slideToggle(500);
});
$('.header-addrw-close').click(function (event) {
    $('.header-addrw').slideToggle(500);
});

//Делает хедер не прозрачным при скролле
$(window).scroll(function () {
    if ($(window).scrollTop() > 80) {
        $('.header').addClass('header-v2')
    } else {
        $('.header').removeClass('header-v2')
    }
});

//Слайдер марок

//Слайдер блока Новости
$('.markiblock-slider').slick({
    infinite: true,
    slidesToShow: 6,
    slidesToScroll: 6,
    autoplay: false,
    lazyLoad: 'progressive',
    responsive: [
        {
            breakpoint: 992,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4
            }
        },
        {
            breakpoint: 576,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3
            }
        },
        {
            breakpoint: 400,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2
            }
        }
    ]
});

//Слайдер блока Акции
$('.akciiblock-slider').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    lazyLoad: 'progressive',
    responsive: [
        {
            breakpoint: 1800,
            settings: {
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
            }
        }
    ]
});
//Малый слайдер наши работы
$('.rabotiblock-slider').slick({
    infinite: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    lazyLoad: 'progressive',
    responsive: [
        {
            breakpoint: 1800,
            settings: {
                slidesToShow: 3,
            }
        },
        {
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
            }
        }
    ]
});

//Показываем или скрываем все марки в Блока Марки со слайдером

$('.markiblock-btn').click(function (event) {
    $('.markiblock-btn-s1').slideToggle(10);
    $('.markiblock-btn-s2').slideToggle(10);
    $('.markiblock-spis').slideToggle(1000);
    $('.markiblock-slider').slideToggle(500);
});

if ($(window).width() > 992) {
    $('.cenablock-card').hover(function (event) {
        $(this).find('.cenablock-card-abs-btnwrap').slideToggle(500);
    })
} else {
    $('.cenablock-card').click(function (event) {
        $(this).find('.cenablock-card-abs-btnwrap').slideToggle(500);
    });
}

//Показываем все услуги в блоке Цены и услуги
$('.cenablock-pokbtn').click(function (event) {
    $('.cenablockdn').slideDown(500)
    $('.cenablock-pokbtn').slideToggle(100)
});

//Показываем весь текст в СЕО-блоках
$('.seo-skrcont-open').click(function (event) {
    $('.seo-skrcont').slideToggle(500)
    $('.seo-skrcont-open').slideToggle(500)
});

// Работа с модальными формами


$("#client_phone").mask("+7 (999) 999-99-99");

$('.modal-form-open').click(function (event) {
    event.preventDefault();
    this.blur();
    let modalForm = $("#modal-form");
    let button = $(this);
    modalForm.find("#recall-form-name").text(button.data('name'));
    modalForm.modal();
});

let dataType = '';

$("#form-recall-send").click(function (event) {
    event.preventDefault();

    let form = $(this).closest('#recall-form');
    let client_name = form.find('input[name=client_name]').val();
    let client_phone = form.find('input[name=client_phone]').val();

    //vacancy
    let vacancy_status = false;
    if (dataType === 'vacancy') {
        vacancy_status = true;
    }

    if (client_name === '') {
        showNotification('Предупреждение!', 'Поле "Имя" не заполнено!', true);
        return false;
    } else if (/[0-9]/.test(client_name)) {
        showNotification('Предупреждение!', 'В поле Имя не могут содержаться цифры!', true);
        return false;
    } else if (/[a-zA-Z]/.test(client_name)) {
        showNotification('Предупреждение!', 'В поле Имя не могут содержаться английские буквы!', true);
        return false;
    } else if (client_phone === '') {
        showNotification('Предупреждение!', 'Поле телефон не заполнено!', true);
        return false;
    }

    if (vacancy_status) {
        $.ajax({
            type: "POST",
            url: '/send_mail',
            data: {
                username: client_name,
                phone: client_phone,
            },
            success: function (data) {
                if (data.success) {
                    showNotification('Отправлено!', 'Ваш отклик на вакансию получен!');
                } else {
                    showNotification('Ошибка!', 'Ой, что то пошло не так, попробуйте позже отправить заявку или перезвоните по указоному номеру!', true);
                }
            },
            error: function (error) {
                showNotification('Ошибка!', 'Ой, что то пошло не так, попробуйте позже отправить заявку или перезвоните по указоному номеру!', true);
            }
        });
        dataType = '';
        return false;
    }

    var paramsString = window.location.host;

    if (paramsString === 'remont-turbiny.com') {
        var groupId = 467916;
    } else {
        // groupId = 325503;
        groupId = 553765;
    }

    if (window.ComagicWidget) {
        console.log(groupId);
        let t = +new Date() + 10000;
        ComagicWidget.sitePhoneCall({
            phone: client_phone,
            group_id: groupId,
            delayed_call_time: t.toString()
        });

        if (paramsString === 'remont-turbiny.com') {
            yaCounter92047965.reachGoal('fos_otpravit');
            console.log('Цель fos_otpravit remont-turbiny');
        } else if (paramsString === 'remont-dizelnogo-dvigatelya.com') {
            yaCounter92047978.reachGoal('fos_otpravit');
            console.log('Цель fos_otpravit remont-dizelnogo-dvigatelya');
        } else if (paramsString === 'remont-dvigatelya.com') {
            yaCounter92048006.reachGoal('fos_otpravit');
            console.log('Цель fos_otpravit remont-dvigatelya');
        }
    }

    showNotification('Отправлено!', 'Ваша заявка получена, мы перезвоним в течении 30 секунд');

    return false;
});

function showNotification(header, message, closeExisting = false) {

    let modal = $("#modal-report");

    modal.find("#modal-report-header").text(header);
    modal.find("#modal-report-massage").text(message);

    if (closeExisting) {
        modal.modal({
            closeExisting: false
        });
    } else {
        modal.modal();
    }
}

$('.form-recall-ok').click(function () {
    var paramsString = window.location.host;
    if (paramsString === 'remont-turbiny.com') {
        yaCounter92047965.reachGoal('fos_okey');
        console.log('Цель fos_okey remont-turbiny');
    } else if (paramsString === 'remont-dizelnogo-dvigatelya.com') {
        yaCounter92047978.reachGoal('fos_okey');
        console.log('Цель fos_okey remont-dizelnogo-dvigatelya');
    } else if (paramsString === 'remont-dvigatelya.com') {
        yaCounter92048006.reachGoal('fos_okey');
        console.log('Цель fos_okey remont-turbiny');
    }
});

$(".mobile-touch-path").on("touchstart", function (event) {
    event.preventDefault();
    let touchButton = $(this);
    let naviPath = touchButton.data("touch");
    window.location = naviPath;
});