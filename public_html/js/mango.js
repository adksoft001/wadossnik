function showHide_perezvon(element_id) {
    $(".phone_mask_perezvon").mask("(999) 999-99-99");
    //Если элемент с id-шником element_id существует
    if (document.getElementById(element_id)) {
        //Записываем ссылку на элемент в переменную obj
        var obj = document.getElementById(element_id);
        //Если css-свойство display не block, то: 
        if (obj.style.display != "block") {
            obj.style.display = "block"; //Показываем элемент
        } else
            obj.style.display = "none"; //Скрываем элемент
    }
    //Если элемент с id-шником element_id не найден, то выводим сообщение
    else
        alert("Элемент с id: " + element_id + " не найден!");
}

$(document).ready(function () {
    $('div.button-widget_perezvon').on('click', function () {
        let phonezrr = $("#phoneperezvon").val();

        if (phonezrr.length < 7) {
            $('#phoneperezvon').css('border', '1px solid #FF0000');
            alert("заполните полое телефон, пожалуйста.");
        }

        if (phonezrr.length > 6) {

            $(this).html('Отправка...');
            $.post(
                "/ajax/mango/",{
                    phonezrr: '7' + phonezrr,
                    do_thisss: 'perezvonishka',
                    _csrf: $('input[name=_csrf]').val()
                },
                function (data) {
                    if (window.ComagicWidget) {

                        let t = +new Date() + 10000;
                        let settings = {
                            "url": "https://admin.qrenta.ru/api/sitephone/get_service?url=r-ms.ru",
                            "method": "GET",
                        };
                        $.ajax(settings).done(function (response) {
                            let id_ploshadki = "311793";
                            if(response['success']){
                                const teg = response['data']['teg'];
                                if(teg === 'sev'){
                                    id_ploshadki = "311793";
                                }else if(teg === 'lbn'){
                                    id_ploshadki = "247097";
                                }else if(teg === 'klg'){
                                    id_ploshadki = "219557";
                                }
                            }
                            ComagicWidget.sitePhoneCall({phone: phonezrr, group_id: id_ploshadki, delayed_call_time: t.toString()});
                        });
                    }
                    showNotification('Отправлено', 'Мы перезвоним через 30 секунд');
                    showHide_perezvon('perethvon0');
                    showHide_perezvon('perethvon');
                    $('.button-widget_perezvon').html('Отправлено');
                    $('#phoneperezvon').remove();
                }
            );
        }
    });
});				