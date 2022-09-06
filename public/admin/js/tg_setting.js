

/*$(document).ready(function () {
    $('#main-bot-start').on('click', function (e) {
       e.preventDefault();  
       var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });      
        $.ajax({  
            type: 'GET',
            url: 'https://api.telegram.org/bot' + "{{ env('TELEGRAM_BOT_TOKEN')}}"+ '/setWebhook?url=' + "{{ env('APP_URL')}}" + '/botman&drop_pending_updates=true',
            //data: $('#form-contact').serialize(),
            success: function (data) {
                if (data.result) {
                        Toast.fire({
                          icon: 'success',
                          title: 'Webhook успешно запущен. Бот начал функционировать'
                        })
                        $('.main_bot_status').text('работает');    
                } else {
                        Toast.fire({
                          icon: 'info',
                          title: 'Запрос прошел, но возникла ошибка'
                        }) 
                }
            },
            error: function () { 
                    Toast.fire({
                      icon: 'error',
                      title: 'Критическая ошибка бот не запущен'
                    })
            }
        });
        
    });
});

$(document).ready(function () {
  $('#main-bot-stop').on('click', function (e) {
     e.preventDefault();  
     var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });      
      $.ajax({  
          type: 'GET',
          url: 'https://api.telegram.org/bot' + "{{ env('TELEGRAM_BOT_TOKEN')}}" + '/deleteWebhook',
          //data: $('#form-contact').serialize(),
          success: function (data) {
              if (data.result) {
                      Toast.fire({
                        icon: 'success',
                        title: 'Webhook успешно удален. Бот перестал работать'
                      })
                      $('.main_bot_status').text('отключен');   
              } else {
                      Toast.fire({
                        icon: 'info',
                        title: 'Запрос прошел, но возникла ошибка'
                      }) 
              }
          },
          error: function () { 
                  Toast.fire({
                    icon: 'error',
                    title: 'Критическая ошибка, не получилось отключить'
                  })
          }
      });
      
  });
});

$(document).ready(function () {
  $('#comment-bot-start').on('click', function (e) {
     e.preventDefault();  
     var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });      
      $.ajax({  
          type: 'GET',
          url: 'https://api.telegram.org/bot' + "{{ env('TELEGRAM_BOT_TOKEN_COMMENT')}}" + '/setWebhook?url=' + "{{ env('APP_URL')}}" + '/botman&drop_pending_updates=true',
          //data: $('#form-contact').serialize(),
          success: function (data) {
              if (data.result) {
                      Toast.fire({
                        icon: 'success',
                        title: 'Webhook успешно запущен. Бот начал функционировать'
                      })
                      $('.comment_bot_status').text('работает');   
              } else {
                      Toast.fire({
                        icon: 'info',
                        title: 'Запрос прошел, но возникла ошибка'
                      }) 
              }
          },
          error: function () { 
                  Toast.fire({
                    icon: 'error',
                    title: 'Критическая ошибка бот не запущен'
                  })
          }
      });
      
  });
});

$(document).ready(function () {
$('#comment-bot-stop').on('click', function (e) {
   e.preventDefault();  
   var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });      
    $.ajax({  
        type: 'GET',
        url: 'https://api.telegram.org/bot' + "{{ env('TELEGRAM_BOT_TOKEN_COMMENT')}}" + '/deleteWebhook',
        //data: $('#form-contact').serialize(),
        success: function (data) {
            if (data.result) {
                    Toast.fire({
                      icon: 'success',
                      title: 'Webhook успешно удален. Бот перестал работать'
                    })
                    $('.comment_bot_status').text('отключен');  
            } else {
                    Toast.fire({
                      icon: 'info',
                      title: 'Запрос прошел, но возникла ошибка'
                    }) 
            }
        },
        error: function () { 
                Toast.fire({
                  icon: 'error',
                  title: 'Критическая ошибка, не получилось отключить'
                })
        }
    });
    
});
});*/