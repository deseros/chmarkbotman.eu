@extends('layouts.admin')

@section('title', 'Просмотр')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

          <h1 class="m-0">Обращение № {{$ticket['bx_ticket_id']}}</h1>
          <div class="card-body">
          <h3 class="text-primary">{{$ticket['subject']}}</h3>
          <p class="text-muted">{{$ticket['description']}}</p>
          <p><b>Отвественный</b> {{ $ticket->user($ticket->assigned_to)->name}}</p>
          <p><b>Постановщик</b> {{ $ticket->user($ticket->provider_id)->name}}</p>
          <p><b>Наименование организации</b>{{$ticket->find_client($user->find_clients($ticket->provider_id)->pivot->client_id)->name_client}}</p>

          </div>
      </div>
      <div class="col-sm-6">
        <div class="card direct-chat direct-chat-primary">
          <div class="card-header">
            <h3 class="card-title">Комментарии</h3>
          </div>

          <!-- /.card-header -->
          <div class="card-body">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
              <!-- Message. Default to the left -->
              @foreach ($ticket->replies as $reply_item)
              <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                  <span class="direct-chat-name float-left">{{ $reply_item->username}}</span>
                  <span class="direct-chat-timestamp float-right">{{$reply_item->created_at}}</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img class="direct-chat-img" src="/admin/dist/img/user1-128x128.jpg" alt="message user image">
                <!-- /.direct-chat-img -->

                @isset($reply_item->replies)
                <div class="direct-chat-text">
                {{ $reply_item->replies}}
              </div>
                @endisset

                @isset($reply_item->files)


                <a href="{{ Storage::disk('images')->url($reply_item->file_path) }}" class="btn-link text-secondary"><i class="fas fa-file"></i> {{ $reply_item->original_name}}</a>

                @endisset

                <!-- /.direct-chat-text -->
              </div>
              @endforeach

            </div>
             </div>
          <!-- /.card-body -->
          <!--<div class="card-footer">
            <form action="#" method="post">
              <div class="input-group">
                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                <span class="input-group-append">
                  <button type="button" class="btn btn-primary">Send</button>
                </span>
              </div>
            </form>
          </div>-->
          <!-- /.card-footer-->
        </div>
      </div>
    </div>
    @if(!empty($media))
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <h4>Фото</h4>
              <div class="card-body">
                <div class="row">
    @foreach($media as $link)
    <div class="col-sm-2">
      <a href="{{ Storage::disk('images')->url($link) }}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
        <img src="{{ Storage::disk('images')->url($link) }}" class="img-fluid mb-2" alt="white sample"/>
      </a>
    </div>
    @endforeach
  </div>
</div>
</div>
</div>
</div>
</div><!-- /.container-fluid -->
</section>
@endif
@if (!empty($document))
<section>
<div class="row">
<div class="col-sm-12">
<h4>Документы</h4>
<ul class="list-unstyled">
@foreach ($document as $document_item)
<li>
<a href="{{ Storage::disk('images')->url($document_item->file_path) }}" class="btn-link text-secondary"><i class="fas fa-file"></i> {{ $document_item->file_name}}</a>
</li>
@endforeach
</ul>
</div>
</div>
</section>
@endif
</div>
</div>
@endsection
