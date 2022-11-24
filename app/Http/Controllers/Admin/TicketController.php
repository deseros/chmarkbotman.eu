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
    public function index(Tags $tags, Request $request, Client $client, User $user)
    {

        $tickets = Ticket::filter($request->all())->paginateFilter();
        return view('admin.ticket.index', [
            'ticket' => $tickets,
            'tags' => $tags->get(),
            'client' => $client->get(),
            'user' => $user->all(),
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
    public function store(Request $request,Ticket $ticket)
    {
        $created_ticket = $ticket->create($request->all());
        $created_ticket->tags()->sync($request->tags);
        return redirect()->back()->withSuccess('Обращение добавлено');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket, User $user)
    {

        return view('admin.ticket.show',[
            'ticket' => $ticket,
            'user' => $user,
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
        $ticket->update($request->all());
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
