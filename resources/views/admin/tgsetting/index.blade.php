@extends('layouts.admin')

@section('title', 'Список пользователей')

@section('content')
<script>
$(document).ready(function(){$.ajax({type:"GET",url:"https://api.telegram.org/bot{{ env('TELEGRAM_BOT_TOKEN')}}/getWebhookInfo",success:function(t){t.result?""==t.result.url?$(".main_bot_status").text("отключен"):$(".main_bot_status").text("работает"):$(".main_bot_status").text("возникли ошибки при запросе")},error:function(){$(".main_bot_status").text("возникли ошибки при запросе")}}),$.ajax({type:"GET",url:"https://api.telegram.org/bot{{ env('TELEGRAM_BOT_TOKEN_COMMENT')}}/getWebhookInfo",success:function(t){t.result?""==t.result.url?$(".comment_bot_status").text("отключен"):$(".comment_bot_status").text("работает"):$(".comment_bot_status").text("возникли ошибки при запросе")},error:function(){$(".comment_bot_status").text("возникли ошибки при запросе")}})});
$(document).ready(function(){$("#main-bot-start").on("click",function(t){t.preventDefault();var e=Swal.mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3});$.ajax({type:"GET",url:"https://api.telegram.org/bot{{ env('TELEGRAM_BOT_TOKEN')}}/setWebhook?url={{ env('APP_URL')}}/botman&drop_pending_updates=true",success:function(t){t.result?(e.fire({icon:"success",title:"Webhook успешно запущен. Бот начал функционировать"}),$(".main_bot_status").text("работает")):e.fire({icon:"info",title:"Запрос прошел, но возникла ошибка"})},error:function(){e.fire({icon:"error",title:"Критическая ошибка бот не запущен"})}})})}),$(document).ready(function(){$("#main-bot-stop").on("click",function(t){t.preventDefault();var e=Swal.mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3});$.ajax({type:"GET",url:"https://api.telegram.org/bot{{ env('TELEGRAM_BOT_TOKEN')}}/deleteWebhook",success:function(t){t.result?(e.fire({icon:"success",title:"Webhook успешно удален. Бот перестал работать"}),$(".main_bot_status").text("отключен")):e.fire({icon:"info",title:"Запрос прошел, но возникла ошибка"})},error:function(){e.fire({icon:"error",title:"Критическая ошибка, не получилось отключить"})}})})}),$(document).ready(function(){$("#comment-bot-start").on("click",function(t){t.preventDefault();var e=Swal.mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3});$.ajax({type:"GET",url:"https://api.telegram.org/bot{{ env('TELEGRAM_BOT_TOKEN_COMMENT')}}/setWebhook?url={{ env('APP_URL')}}/commentwebhook&drop_pending_updates=true",success:function(t){t.result?(e.fire({icon:"success",title:"Webhook успешно запущен. Бот начал функционировать"}),$(".comment_bot_status").text("работает")):e.fire({icon:"info",title:"Запрос прошел, но возникла ошибка"})},error:function(){e.fire({icon:"error",title:"Критическая ошибка бот не запущен"})}})})}),$(document).ready(function(){$("#comment-bot-stop").on("click",function(t){t.preventDefault();var e=Swal.mixin({toast:!0,position:"top-end",showConfirmButton:!1,timer:3e3});$.ajax({type:"GET",url:"https://api.telegram.org/bot{{ env('TELEGRAM_BOT_TOKEN_COMMENT')}}/deleteWebhook",success:function(t){t.result?(e.fire({icon:"success",title:"Webhook успешно удален. Бот перестал работать"}),$(".comment_bot_status").text("отключен")):e.fire({icon:"info",title:"Запрос прошел, но возникла ошибка"})},error:function(){e.fire({icon:"error",title:"Критическая ошибка, не получилось отключить"})}})})});
$(document).ready(function(){
  $main_stroka =  $('#name_app').val();
  $upd_stroka = $main_stroka.replace("&nbsp" , " ");
  $('#name_app').val($upd_stroka);
})
</script>
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          
          <h1 class="m-0">Настройки приложения</h1>
        </div><!-- /.col -->
        @if (session('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
        </div>
    @endif
      </div><!-- /.row -->
     
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row mb-2">
           
          </div>
        </div><!-- /.container-fluid -->
      </section>
  
      
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
    <div class="col-12">
        <form  action={{ route('update_setting')}} method="POST">
            @csrf
          <div class="card-body">
            <div class="form-group">
              <label for="name-client">Домен приложение (указывать с https без слеша)</label>
              <input type="text" name="name_app" value="{{ env('APP_URL') }}" class="form-control" id="name_app" placeholder="Укажите домен" required>
            </div>
            <div class="form-group">
              <label for="name-client">Токен Бота Поддержки</label>
              <input type="text" name="token_bot_main" value="{{ env('TELEGRAM_BOT_TOKEN') }}" class="form-control" id="token_bot_main" placeholder="Токен основого бота" required>
            </div>
            <div class="form-group">
              <label for="name-client">Токен бота комментариев</label>
              <input type="text" name="token_bot_comment" value="{{ env('TELEGRAM_BOT_TOKEN_COMMENT') }}" class="form-control" id="token_bot_comment" placeholder="Токен бота комметариев" required>
            </div>
            <div class="form-group">
              <label for="name-client">Вебхук битрикс</label>
              <input type="text" name="bx_webhook" value="{{ env('BX_WEBHOOK') }}" class="form-control" id="bx_webhook" placeholder="Битрикс вебхук" required>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Обновить</button>
              </div>   
        </form>
       
        <div class="form-group">
        <h2>Основной бот</h2>
        <div class="row">
         <div class="col-md-3">
          <button type="button" class="btn btn-block btn-primary" id="main-bot-start">Запустить / перезапустить</button>
         </div>
         <div class="col-md-3">
          <button type="button" class="btn btn-block btn-primary" id="main-bot-stop">Отключить</button>
         </div>
       
        </div>
       
       <p><b>Статус работы:</b> <span class="main_bot_status"> </span></p>    
      
      
       
  
        </div>

        <div class="form-group">
          <h2>Бот для комментариев</h2>
          <div class="row">
           <div class="col-md-3">
            <button type="button" class="btn btn-block btn-primary"  id="comment-bot-start">Запустить / перезапустить</button>
           </div>
           <div class="col-md-3">
            <button type="button" class="btn btn-block btn-primary"  id="comment-bot-stop">Отключить</button>
           </div>
       
          </div>
      
         <p><b>Статус работы:</b> <span class="comment_bot_status"> </span></p>    
         
        
         
    
          </div>
    </div>
  
             
        </section>
        
@endsection