@extends('layouts.admin')

@section('title', 'Добавление клиента')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Добавление тега</h1>
        </div><!-- /.col -->
       
      </div><!-- /.row -->
      @if (session('success'))
      <div class="alert alert-success" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
      </div>
  @endif
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
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
            <form action="{{ route('tags.store')}}" method="POST">
                @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="name_tags">Название тега</label>
                  <input type="text" name="name_tags" class="form-control" id="name_tags" placeholder="Укажите название клиента" required>
                </div>
                <div class="form-group">
                    <label>Тип тега</label>
                    <select name="type_tags" class="form-control">
                      <option value="status">status</option>
                      <option value="custom">custom</option>
                    </select>
                  </div>
                <div class="form-group">
                  <label for="bx_user_id">Текст для уведомления об изменении статуса</label>
                  <textarea type="text"  name="notif_text" class="form-control" id="notif_text" placeholder="Данный текст будет использован при отправке уведомлений"></textarea>
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