@extends('layouts.admin')

@section('title', 'Редактирование записи')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование пользователя</h1>
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
           
                <form action={{ route('users.update',$user['id'])}} method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name-client">ФИО или наименование</label>
                      <input type="text" name="username" value="{{ $user['name'] }}" class="form-control" id="name-client" placeholder="Введите название" required>
                    </div>
                    <div class="form-group">
                        <label for="email-user">Email</label>
                        <input type="email" name="email" value="{{ $user['email'] }}" class="form-control" id="email-user" placeholder="Введите название" required>
                    </div>
                    <div class="form-group">
                      <label for="user-pass">Пароль</label>
                      <input type="password" name="password" value="" class="form-control" id="user-pass" placeholder="Введите новый пароль">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Добавить аватар</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" value="{{ Storage::url($user['avatar']) }}" name="avatar" class="custom-file-input" id="exampleInputFile">
                        @if ($user['avatar'] != null)
                        <label class="custom-file-label" for="exampleInputFile">{{ Storage::url($user['avatar']) }}</label>  
                        @else
                        <label class="custom-file-label" for="exampleInputFile">Выберите фаил</label>
                        @endif
                        
                      </div>
                    </div>
                  </div>
                  @if ($user['avatar'] != null)
                  <img src="{{ Storage::url($user['avatar']) }}" alt="" width="20%">
                @endif
                <div class="form-group">
                  <label for="bx_name">Выберите свой профиль из битрикс24</label>
                    <select name="bx_name" class="form-control" required>
                      @foreach ($bx_user as $bx_item)
                          <option value="{{ $bx_item['ID'] }}">
                      {{ $bx_item['NAME'] }} {{ $bx_item['LAST_NAME'] }}
                      </option>
                      @endforeach
                  </select>
                  </div>
                
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Обновить</button>
              </div>
            </form>
          </div>
    </div>
        </section>
      
@endsection