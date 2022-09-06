@extends('layouts.admin')

@section('title', 'Список клиентов')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Теги</h1>
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
          </div>
          <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            ID
                        </th>
                        <th style="width: 20%">
                           Название
                        </th>  
                        <th style="width: 15%">
                            Тип
                        </th>
                        <th style="width: 20%">
                        
                         </th>  
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tags as $tags_item)
                      <tr>
                          <td>
                     {{$tags_item->id}}
                          </td>
                          <td>
                          {{$tags_item->name_tags}}
                          </td>
                          <td>
                            {{$tags_item->type_tags}}
                          </td>
                          <td class="project-actions text-right">
                            
                              <a class="btn btn-info btn-sm" href="{{ route('tags.edit', $tags_item->id)}}">
                                  <i class="fas fa-pencil-alt">
                                  </i>
                                  Изменить
                              </a>
                              <form action="{{ route('tags.destroy', $tags_item->id)}}" method="POST">
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