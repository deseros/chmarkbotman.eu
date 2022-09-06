@extends('layouts.admin')

@section('title', 'Список клиентов')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Список клиентов</h1>
        </div><!-- /.col -->
       
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
        <div class="card">
          <div class="card-header">
            
  
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            ID
                        </th>
                        <th style="width: 20%">
                           Название клиента
                        </th>  
                        <th style="width: 28%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client )
                    <tr>
                        <td>
                            {{ $client['id']}}
                        </td>
                        <td>
                            <a>
                                {{ $client['name_client']}}
                            </a>
                            <br/>
                            <small>
                                {{ $client['created_at']}}
                            </small>
                        </td>
                     
    
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{ route('client.edit', $client['id'])}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Изменить
                            </a>
                            <form action="{{route('client.destroy',$client['id'])}}" method="POST">
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