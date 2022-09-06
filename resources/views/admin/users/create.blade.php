@extends('layouts.admin')

@section('title', 'Добавление клиента')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавление пользователя</h1>
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
            <form action={{ route('users.store')}} method="POST" enctype="multipart/form-data">
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name-client">ФИО или наименование</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Введите название" required>
                </div>
                <div class="form-group">
                    <label for="email-user">Email</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Почта" required>
                </div>
                <div class="form-group">
                  <label for="user-pass">Пароль</label>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Пароль" required>
              </div>
                <div class="form-group">
                  <label for="exampleInputFile">Добавить аватар</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" name="avatar" class="custom-file-input" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Выберите фаил</label>
                    </div>
                    <div class="input-group-append">
                      <span class="input-group-text">Загрузить</span>
                    </div>
                  </div>
                </div>
                
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