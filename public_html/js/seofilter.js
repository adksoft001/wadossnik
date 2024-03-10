(function ($) {
    var brand = "";
    var model = "";
    var district ="";
    var metro = "";
    var md = "";
    var path = "";
    var county = "";
    var service = "avtoservis"
    $( document ).ready(function() {
        console.log(brand + " Brand")
    });

    $(document).on('click','.filter-restore label', function () {
        $('.filter-restore label').not(this).removeClass('active');
        $('.filter-restore label').not(this).siblings('ul').removeClass('active');
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $(this).siblings('ul').addClass('active');
            overlayCheck();
        } else {
            $(this).removeClass('active');
            $(this).siblings('ul').removeClass('active');
        }
    });

    $('.restore-button').on('click', function () {
        //console.log($('.metro-lable').text() == " Hello Hello!")
        if($('.metro-lable').text() == "Метро" && $('.district-lable').text() == "Район" && $('.county-lable').text() == "Округ"){
        $('.restore-dis').each(function() {
                    $(this).addClass('input__alarm');
        });

        $('.restore-subway').each(function() {
            $(this).addClass('input__alarm');
        });

        $('.restore-county').each(function() {
            $(this).addClass('input__alarm');
        });

        setTimeout(function() {
            $('#restore-district').removeClass('input__alarm');
            $('#restore-subway').removeClass('input__alarm');
            $('#restore-county').removeClass('input__alarm');
        }, 1000);
        } else {
            var url = window.location.pathname;
            if(url === "/"){
                url = "..";
            }
            goToPage(url, metro, model, brand, service);
        }

    });

    function goToPage(url, metro, model, brand, service){
       // console.log(district + " Район " + district.length)

            if(metro.length > 1){
                path = url+"/"+brand+"/"+metro+"/"+service;
                document.location.href = path.replace('//', '/');
            } else if(district.length > 1)  {
                path =  url+"/"+brand+"/"+district+"/"+service;
                document.location.href = path.replace('//', '/') ;
            } else if(county.length > 1){
                path =  url+"/"+brand+"/"+county+"/"+service;
                document.location.href = path.replace('//', '/') ;
            }


    }

    function overlayCheck() {
        if ($('.big-filter-restore').hasClass('active')) {
            $('.big-filter-restore__overlay').addClass('active');
        }
    }

    $(document).on('click', '.filter-restore .header-card-vip-close2',  function () {
        $('.filter-restore label').removeClass('active');
        $('.filter-restore ul').removeClass('active');
        $('.big-filter-restore__overlay').removeClass('active');
    });

    $(document).mouseup( function(e){
        if ($('.big-filter-restore').hasClass('active')) {
            var div = $('.big-filter-restore');
            if (!div.is(e.target) && div.has(e.target).length === 0 ) {
                $('.filter-restore label').removeClass('active');
                $('.filter-restore ul').removeClass('active');
                $('.big-filter-restore__overlay').removeClass('active');
            }
        }
    });

    $(document).on('click', '.filter-restore li',  function () {
        $('.filter-restore li').siblings('li').removeClass('check');
        $(this).addClass('check');
        $(this).closest('ul').removeClass('active');
        $(this).closest('ul').siblings('label').removeClass('active');
        $('.big-filter-restore__overlay').removeClass('active');
        checkServices($(this).text());
        labelPrint();

    });

    function checkServices(dataModel){
        console.log(dataModel);
        if(dataModel== "Слесарный ремонт"){
            service ="remont";
        }
        if(dataModel== "Кузовной ремонт"){
            service ="kuzovnoj-remont";
        }
        if(dataModel== "Техническое обслуживание"){
            service ="tehnicheskoe-obsluzhivanie";

        }
       //console.log(service);
    }


    function labelPrint() {
 $('.filter-restore').each(function () {
     //console.log("Ya tut!")
     let label = $(this).find('.check').text();
     if (label.length > 0) {
         $(this).find('label').text(label);

         if ($(this).hasClass('restore-subway')) {
             if ($(this).find('.remove-filter-trigger').length == 0) {
                 $(this).prepend('<div class="remove-filter-trigger fil-met"></div>');
                 $(this).find('label').addClass('remove-filter');
             }

             $('.fil-dis').remove();
             $('.district-lable').text("Район");
             $('.restore-dis').siblings("label").text("Район").removeClass('remove-filter');
             $('.fil-county').remove();
             $('.county-lable').text("Округ");
             county = "";
             district = "";
             metro = $(this).find('.check').data("id");//remove-filter-trigger


         }

         if ($(this).hasClass('restore-county')) {
             if ($(this).find('.remove-filter-trigger').length == 0) {
                 $(this).prepend('<div class="remove-filter-trigger fil-county"></div>');
                 $(this).find('label').addClass('remove-filter');
             }

             $('.fil-dis').remove();
             $('.district-lable').text("Район");
             $('.metro-lable').text("Метро");
             $('.restore-dis').siblings("label").text("Метро").removeClass('remove-filter');
             county = $(this).find('.check').data("id");//remove-filter-trigger
         }

         if ($(this).hasClass('restore-m')) {
             model = $(this).find('.check').data("id");
         }

         if ($(this).hasClass('restore-dis')) {

             console.log("Район - " + district)
             if ($(this).find('.remove-filter-trigger').length == 0) {
                 $(this).prepend('<div class="remove-filter-trigger fil-dis"></div>');
                 $(this).find('label').addClass('remove-filter');
             }
             $('.fil-met').remove();
             $('.metro-lable').text("Метро");
             metro = "";
             $('.fil-county').remove();
             $('.county-lable').text("Округ");
             county = "";

             district = $(this).find('.check').data("id");
             console.log("Район - " + district)
         }


     }

     if ($('#restore-brand li.check').length > 0) {
         $('#restore-model').removeClass('filter-hide');
     } else if ($('#restore-district li.check').length > 0) {
         $('#restore-subway').removeClass('filter-hide');
     }
 });
}

$(document).on('click','.remove-filter-trigger', function () {

    if($(this).hasClass('fil-met')){
        $(this).siblings('label').text("Метро").removeClass('remove-filter');
        $(this).remove();
    }

    if($(this).hasClass('fil-dis')){
        $(this).siblings('label').text("Район").removeClass('remove-filter');
        $(this).remove();
    }

    if($(this).hasClass('fil-county')){
        $(this).siblings('label').text("Округ").removeClass('remove-filter');
        $(this).remove();
    }


});

})(jQuery);