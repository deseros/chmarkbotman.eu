@extends('layouts.admin')

@section('title', 'Добавление клиента')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавление клиента</h1>
        </div><!-- /.col -->
       
      </div><!-- /.row -->
      @if (session('success'))
      <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
      </div>
  @endif
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="card card-primary">

            <!-- form start -->
            <form action={{ route('client.store')}} method="POST">
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name-client">Наименование клиента</label>
                  <input type="text" name="name_client" class="form-control" id="name-client" placeholder="Укажите название клиента" required>
                </div>
                <div class="form-group">
                  <label for="bx_group_id">ID группы в битрикс24</label>
                  <input type="textarea" required name="bx_id_group" class="form-control" id="bx_group_id" placeholder="Укажите ID группы в битриксе24">
                </div>
                <div class="form-group">
                  <label for="bx_user_id">ID Пользователя из битрикса24</label>
                  <input type="textarea" required name="bx_id_user" class="form-control" id="bx_user_id" placeholder="Укажите ID пользователя в битриксе24">
                </div>
                <div class="form-group">
                  <label for="channel_chat_id">ID канала для пересылки сообщений Telegram</label>
                  <input type="textarea" required name="channel_chat_id" class="form-control" id="channel_chat_id" placeholder="Укажите ID канала (обычно начинается со знака минус)">
                </div>
                <div class="form-group">
                  <label for="invait_link_channel">Пригласительная ссылка в Telegram канал клиента</label>
                  <input type="textarea" required name="invait_link_channel" class="form-control" id="invait_link_channel" placeholder="Укажите инвайт ссылку">
                </div>
                <div class="form-group">
                  <label for="key_license_telegram">Лицензионный ключ к Telegram боту</label>
                  <div class="row">
                    <div class="col-md-10 col-lg-10 col-12">
                  <input type="textarea" required name="key_license_telegram" class="form-control" id="key_license_telegram" placeholder="Выполните генерацию ключа">
                    </div>
                    <div class="col-md-2 col-lg-2 col-12">
                  <button type="button"  id="key-gen" class="btn btn-block btn-primary btn-flat">Генерация ключа</button>
                    </div>  
                </div>
                </div>
                
                <!--<div class="form-group">
                  <label for="exampleInputFile">Добавить файлы</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Выберите фаил</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Загрузить</span>
                    </div>
                  </div>
                </div>-->
                
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Добавить</button>
              </div>
            </form>
          </div>
    </div>
        </section>
      
@endsection