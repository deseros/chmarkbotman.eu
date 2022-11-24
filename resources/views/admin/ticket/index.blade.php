@extends('layouts.admin')

@section('title', 'Список клиентов')

@section('content')
<style>
.filter_item_container label{
margin-left:10px;
}
</style>
<script>
    $(document).ready(function(){
        $('.ticket_sort').on('change', function (e) {
        //var optionSelected = $("option:selected", this);
        //var valueSelected = this.value;
        alert(this.value);
    });
    });
    </script>
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
            <div class="row">
           <div class="col-md-6">
           <h2>Фильтры</h2>
           </div>
           <div class="col-md-6">
            <form class="search-form" action="{{ route('tickets.index')}}" method="GET">
              <div class="input-group">
                <input type="text" name="subject" class="form-control" placeholder="Искать по названию">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
              <!-- /.input-group -->
            </form>
           </div>
            </div>
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
            <form action="{{ route('tickets.index')}}" method="GET" class="filter_container">
           <div class="row">
          <div class="col-md-3">
          <p class="filter_head_block">Статус заявки</p>
       <div class="filter_item_content">
          @foreach ($tags as $tags_item)
          <div class="filter_item_container">
          <input
          type="checkbox" id="tags" name="tags[{{$loop->index}}]" value="{{$tags_item['id']}}"  @if (request()->has('tags'))
          @if (in_array($tags_item['id'], Request()->tags)) checked @endif
          @endif><label for="tags">{{$tags_item['name_tags']}}</label>
          </div>
          @endforeach
          </div>
          </div>

          <div class="col-md-3">
            <p class="filter_head_block">Клиент</p>
            <div class="filter_item_content"  style="height: 200px; overflow-y: scroll;">
                @foreach ($client as $client_item)
                <div class="filter_item_container">
                 <input
                 type="checkbox" id="client" name="client[{{$loop->index}}]" value="{{$client_item['id']}}"  @if (request()->has('client'))
                 @if (in_array($client_item['id'], Request()->client)) checked @endif
                 @endif><label for="client">{{$client_item['name_client']}}</label>
                 </div>

                @endforeach
            </div>

          </div>
          <div class="col-md-3">
            <p class="filter_head_block">Ответственный</p>
            <div class="filter_item_content" style="height: 200px; overflow-y: scroll;">
                @foreach ($user as $user_item)
                <div class="filter_item_container">
                 <input
                 type="checkbox" id="assign" name="assign[{{$loop->index}}]" value="{{$user_item['id']}}"  @if (request()->has('assign'))
                 @if (in_array($user_item['id'], Request()->assign)) checked @endif
                 @endif><label for="assign">{{$user_item['name']}}</label>
                 </div>

                @endforeach
            </div>

          </div>

          <div class="col-md-12">
           <button type="btn btn-block btn-primary btn-flat" style="float:right; margin-top:30px; color: #fff;
           background-color: #007bff;
           border-color: #007bff;">Фильтровать</button>
           </div>
        </form>
          </div>
        </div>
      </section>

      <section class="content">

        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <div class="col-md-3">
              <label for="exampleSelectBorder">Сортировка</code></label>
              <select name="sort" class="custom-select form-control-border ticket_sort" id="exampleSelectBorder" placeholder="Выберите сортировку">
                <option value="created_at">Дата по возрастанию</option>
                <option value="-created_at">Дата по убыванию</option>
              </select>
              </div>
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

                         <td>{{$ticket_item->provider(1)}}</td>
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

    {{ $ticket->links('layouts.pagination') }}

        </section>

@endsection

