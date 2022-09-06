@extends('layouts.admin')

@section('title', 'Редактирование записи')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Редактирование записи </h1>
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
           
                <form action={{ route('tickets.update',$ticket['id'])}} method="POST">
                  @csrf
                  @method('PUT')
           
                
                  <div class="card-body">
                    <div class="form-group">
                      <label for="name-client">Тема</label>
                      <input type="text" name="subject" value="{{ $ticket['subject'] }}" class="form-control" id="name-client" placeholder="Введите название" required>
                    </div>
                    <div class="form-group">
                        <label for="desc-client">Описание проблемы</label>
                        <input type="text" name="description" value="{{ $ticket['description'] }}" class="form-control" id="desc-client" placeholder="Введите название" required>
                    </div>
                    <div class="form-group">
                    <label for="client-name">Выберите клиента</label>
                      <select name="client_id" class="form-control" required>
                        @foreach ($client as $client_item)
                            <option value="{{ $client_item['id'] }}" @if ($client_item['id'] == $ticket['client_id']) selected
                        @endif>{{ $client_item['name_client'] }}
                        </option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">

                      <label for="tags">Статус заявки</label>
                        <select name="tags" class="form-control" required>
                          @foreach ($tags as $tags_item)
                              <option value="{{ $tags_item['id'] }}" @if ($tags_item['id'] == $ticket->tags[0]['pivot']['tags_id']) selected
                              @endif
                              >{{ $tags_item['name_tags'] }}</option>
                          @endforeach
                      </select>
                      </div>
                      <div class="form-group">
                        <label for="tags">Ответственный специалист</label>
                          <select name="assign_to" class="form-control" required>
                            @foreach ($user as $user_item)
                                <option value="{{ $user_item['id'] }}">{{ $user_item['name'] }}</option>
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