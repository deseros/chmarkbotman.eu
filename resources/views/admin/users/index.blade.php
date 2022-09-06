@extends('layouts.admin')

@section('title', 'Список пользователей')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Список пользователей</h1>
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
                           ФИО или название
                        </th> 
                        <th style="width: 30%">
                            Email
                         </th> 
                        <th style="width: 28%">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $user_item )
                    <tr>
                        <td>
                            {{ $user_item['id']}}
                        </td>
                        <td>   
                                {{ $user_item['name']}}
                            <br/>
                            <small>
                                {{ $user_item['created_at']}}
                            </small>
                        </td>
                        <td>
                            {{ $user_item['email']}}  
                        </td>
    
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user_item['id'])}}">
                                <i class="fas fa-pencil-alt">
                                </i>
                                Изменить
                            </a>
                            <form action="{{route('users.destroy',$user_item['id'])}}" method="POST">
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
            {{ $user->links('layouts.pagination') }}
           
          </div>    
    </div>
        </section>
      
@endsection