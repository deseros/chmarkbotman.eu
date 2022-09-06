<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Controllers\Admin\Hooks\ClientHooks;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->get();
        return view('admin.client.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_client = new Client();
        $new_client->name_client = $request->name_client;
        $new_client->bx_id_group = $request->bx_id_group;
        $new_client->bx_id_user = $request->bx_id_user;
        $new_client->channel_chat_id = $request->channel_chat_id;
        $new_client->invait_link_channel = $request->invait_link_channel;
        $new_client->key_license_telegram = $request->key_license_telegram;

        $new_client->save();

        return redirect()->back()->withSuccess('Клиент успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client, ClientHooks $bx24)
    {
       
        return view('admin.client.edit',[
            'client' => $client,
            'bx_group' => $bx24->find_group()
        ]);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $client->name_client = $request->name_client;
        $client->bx_id_group = $request->bx_id_group;
        $client->bx_id_user = $request->bx_id_user;
        $client->channel_chat_id = $request->channel_chat_id;
        $client->invait_link_channel = $request->invait_link_channel;
        $client->key_license_telegram = $request->key_license_telegram;
        $client->save();

        return redirect()->back()->withSuccess('Клиент успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->back()->withSuccess('Категория была успешно удалена!');
    }
}
