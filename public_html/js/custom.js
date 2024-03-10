/*Zaloba*/
$('.modal-form-zaloba').click(function(event) {
   event.preventDefault();
   this.blur();

   let modalForm = $("#modal-zaloba");
   let button = $(this);
   let serviceSpace = $("#service-space");


   modalForm.find("#recall-form-name").text(button.data('name'));

   serviceSpace.empty();
   console.log(serviceSpace);

   if(button.data('service')) {
      console.log('exists service');

      let hiddenInput = $('<input>', {
         'id':'service-name',
         'type':'hidden',
         'name':'service',
         'value':button.data('service')
      });
      hiddenInput.appendTo(serviceSpace);

   } else {
      console.log('no service');

      if(servicesJson) {
         let select = $('<select>', {
            'id':'service-name',
            'class':'form-control',
            'name':'service'
         });

         for(var val in servicesJson) {
            let option = $('<option>', {
               'value':val,
               text: servicesJson[val]
            });
            option.appendTo(select);
         }

         serviceSpace.append(
             $('<div>', {
                'class':'form-group'
             }).append(
                 $('<label>', {
                    'for':'service-name',
                    text:'Выберите сервис'
                 })
             ).append(
                 select
             )
         );
      }
   }

   modalForm.modal();
});

/* Обработка отправки */

$(".modal-zaloba  #recall-form #form-recall-send").click(function(event) {
   event.preventDefault();

   let form = $(this).closest('#recall-form');
   let client_name = form.find('input[name=client_name]').val();
   let client_phone = form.find('input[name=client_phone]').val();
   let client_email = form.find('input[name=client_email]').val();
   let urgently  = false;
   if(urgently_report.checked){
      urgently = true;
   }
   /*let urgently_report = form.find(urgently_report.checked);*/
   let text_report = form.find('textarea[name=text-report]').val();
   let type = form.find('input[name=type]').val();
   let service = form.find('#service-name').val();
   let vacancy_status = false;


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
   } else if (service === '') {
      showNotification('Предупреждение!', 'Вы не выбрали предпочтительный сервис!', true);
      return false;
   } else if (!form.find("input[name=obrabotkaDanix]").prop("checked")) {
      showNotification('Предупреждение!', 'Вы не дали согласие на обработку персональных данных!', true);
      return false;
   }
   else if (text_report === ''){
      showNotification('Предупреждение!', 'Оставьте текст жалобы!', true);
      return false;
   }

   $("#form-recall-send").text('Отправляется...');


   if (window.ComagicWidget && !vacancy_status) {
      let t = +new Date() + 10000;
      let id_ploshadki = '311793';
      if (service === 'lobnenskaya') {
         id_ploshadki = '247097';
      }
      if (service === 'sevastopolskiy') {
         id_ploshadki = '311793';
      }
      if (service === 'kalugskaya') {
         id_ploshadki = '219557';
      }
      if(client_phone === '+7 (000) 000-00-00'){
         console.log('стоп дозвон');
         console.log(client_phone);
         console.log(id_ploshadki);
      }else{
         ComagicWidget.sitePhoneCall({phone: client_phone, group_id: id_ploshadki, delayed_call_time: t.toString()});
      }
   }

   $.ajax({
      type: "POST",
      url: '/ajax/sendcall/',
      data: {
         username: client_name,
         phone: client_phone,
         email: client_email,
         urgently: urgently,
         text: text_report,
         service: service,
         type: type,
         _csrf: form.find('input[name=_csrf]').val()
      },
      success: function (respond, status, jqXHR) {
         if (typeof respond.error === 'undefined') {
            //yaCounter5921719.reachGoal('ostavit_zayavku');
            let response = JSON.parse(respond);
            form.closest('.modal').modal('hide');
            if(vacancy_status)
               showNotification('Отправлено!', 'Ваш отклик на вакансию получен!');
            else
               showNotification('Отправлено!', 'Ваше сообщение получено, вскоре мы вам ответим');
            $("#form-recall-send").text("Отправить");
         } else {
            let error = 'ОШИБКА: ' + respond.data;
            showNotification('Ошибка!', error, true);
            console.log(error);
            $("#form-recall-send").text("Отправить");
         }
      },
      error: function (jqXHR, status, errorThrown) {
         let error = 'ОШИБКА AJAX запроса: ' + status;
         showNotification('Ошибка!', error, true);
         console.log(error, jqXHR);
         $("#form-recall-send").text("Отправить");
      }
   });

   return false;

});

/*Zaloba end*/