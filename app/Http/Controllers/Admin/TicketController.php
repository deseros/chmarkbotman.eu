<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\TicketMedia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Tags;
use App\Models\User;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tags $tags, Request $request)
    {
      
        $tickets = Ticket::orderBy('created_at', 'desc')->paginate(10);
    
        return view('admin.ticket.index', [
            'ticket' => $tickets,
            'tags' => $tags->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tags $tags, User $user)
    {
        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('admin.ticket.create', [
            'client' => $clients,
            'tags' => $tags->where('type_tags', '=', 'status')->get(),
            'user' => $user->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = new Ticket();
        $ticket->subject = $request->subject;
        $ticket->description = $request->description;
        $ticket->client_id = $request->client_id;
        $ticket->bx_ticket_id = $request->bx_ticket_id;
        $ticket->assign_to = $request->assign_to;
        $ticket->save();
        $ticket->tags()->sync($request->tags);
        return redirect()->back()->withSuccess('Обращение добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $media_box = [];
        $docum_box = [];
        $reply_box = [];
    
        $clients = Client::where('id', '=', $ticket['client_id'])->first();
        $media = TicketMedia::where('ticket_id', '=', $ticket['id'])->get();
        foreach($media as $media_item){
            if($media_item->mime_type == 'photo'){
            $media_box[] = $media_item->file_path;
            }
            if($media_item->mime_type == 'document'){
               $docum_box[] =  $media_item;
            }
        }
        $replies = DB::table('ticket_replies')->where('ticket_id', '=', $ticket['tg_channel_msg_id'])->get();
        foreach($replies as $rep_item){
            $reply_box[] = $rep_item;
        }
        $reply_media = DB::table('replies_medias')->where('ticket_id', '=', $ticket['tg_channel_msg_id'])->get();
        foreach($reply_media as $med_item){
            $reply_box[] = $med_item;
          
        }   
        return view('admin.ticket.show',[
            'ticket' => $ticket,
            'client' => $clients,
            'media' => $media_box,
            'document' => $docum_box,
            'reply_msg' => collect($reply_box)->sortBy('created_at')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket, Tags $tags, User $user)
    {
        
        $clients = Client::orderBy('created_at', 'desc')->get();
       
        return view('admin.ticket.edit',[
            'ticket' => $ticket,
            'client' => $clients,
            'tags' => $tags->getTaskStatus(),
            'user' => $user->orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        $ticket->subject = $request->subject;
        $ticket->description = $request->description;
        $ticket->client_id = $request->client_id;
        $ticket->bx_ticket_id = $request->bx_ticket_id;
        $ticket->assigned_to = $request->assign_to;
        $ticket->save();
        $ticket->tags()->sync($request->tags);
        return redirect()->back()->withSuccess('Обращение успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        DB::table('taggables')->where('taggable_id', '=', $ticket->id)->delete();
        $ticket->delete();
        return redirect()->back()->withSuccess('Обращение было удалено');
    }
}
