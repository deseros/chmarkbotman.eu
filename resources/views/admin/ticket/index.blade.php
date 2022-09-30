@extends('layouts.admin')

@section('title', 'Список клиентов')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Список обращений</h1>
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
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
           <h2>Фильтры</h2>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('tickets.index')}}" method="GET" class="filter_container" style="display: flex">
           
          <div class="col-md-3">
          <label for="exampleSelectBorder">Статус заявки</code></label>
          <select name="tags" class="custom-select form-control-border" id="exampleSelectBorder">
            <option value="">Выберите статус</option>
            @foreach ($tags as $tags_item)
            <option value="{{$tags_item['id']}}" @if(request()->has('tags')) selected @endif>{{$tags_item['name_tags']}} </option>
            @endforeach
          </select>
   
          </div>
          <div class="col-md-3">
          <label for="exampleSelectBorder">Клиент</code></label>
          <select name="client" class="custom-select form-control-border" id="exampleSelectBorder">
            <option value="">Выберите клиента</option>
            <option>Value 2</option>
            <option>Value 3</option>
          </select>
          </div>
          <div class="col-md-3">
          <label for="exampleSelectBorder">Сортировка</code></label>
          <select name="sort" class="custom-select form-control-border" id="exampleSelectBorder">
            <option value="">Выбрать сортировку</option>
            <option value="created_at">Дата по возрастанию</option>
            <option value="-created_at">Дата по убыванию</option>
          </select>
          </div>
          <div class="col-md-3">
           <button type="submit">Фильтровать</button>
          </div>
        </form>
          </div>
        </div>
      </section>
      
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
               
          </div>
          <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            ID
                        </th>
                        <th style="10%">
                        Статус
                        </th>
                        <th style="width: 10%">
                           Тема обращение
                        </th>
                        <th style="width: 10%">
                          Клиент
                       </th>  
                       <th style="width: 15%">
                      Отвественный  
                      </th>  
                      <th style="width: 10%">Дата создания</th>
                        <th style="width: 28%">
                        </th>
                    </tr>
                </thead>
                <tbody>
              
                    @foreach ($ticket as $ticket_item )
                    <tr>
                      
                        <td>
                            {{ $ticket_item['id']}}
                        </td>
                        <td>
                          @foreach ($ticket_item->tags as $item_tags)
                              {{$item_tags['name_tags']}}
                          @endforeach
                        </td>
                        <td>
                            <a>
                                {{ $ticket_item['subject']}}
                            </a>
                            <br/>
                       
                        </td>
                         <td>{{ $ticket_item->cur_client['name_client']}}</td>
                         <td> 
                         @if ($ticket_item['assigned_to'])
                         {{$ticket_item->assignee['name']}}
                         @else
                             Не назначено
                         @endif 
                         </td>
                         <td>
                          {{ $ticket_item['created_at']}}
                         </td>
                        <td class="project-actions text-right">
                          <a class="btn btn-info btn-sm" href="{{ route('tickets.show', $ticket_item['id'])}}">
                            <i class="fas fa-pencil-alt">
                            </i>
                            Детали
                        </a>
                            <a class="btn btn-info btn-sm" href="{{ route('tickets.edit', $ticket_item['id'])}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Изменить
                            </a>
                            <form action="{{route('tickets.destroy',$ticket_item['id'])}}" method="POST">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash">
                                </i>
                                Удалить
                            </button>
                            </form>
                            
                        </td>
                    </tr>  
                    @endforeach
                    
                  
                </tbody>
            </table>
           
           
          </div>    
    </div>

     
     
        </section>
       
@endsection