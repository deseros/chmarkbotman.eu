<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Http\Controllers\Admin\Hooks\ClientHooks;
use App\Models\User;
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
    public function create(User $user)
    {
        return view('admin.client.create', [
            'user' => $user->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Client $client)
    {


        $this->validate($request, [
            'name_client' => 'required|string|min:3|max:255',
            'bx_id_group' => 'required|integer',
             'bx_id_user' => 'required|integer',
             'channel_chat_id' => 'required|string',
             'invait_link_channel' => 'required|string',
             'key_license_telegram' => 'required|string|max:40',
        ]);
        $current_client = $client->create($request->all());
        //$client->save();
        $current_client->users()->sync($request->array_users);
        //dd($request->all());

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
    public function edit(Client $client, ClientHooks $bx24, User $user)
    {
       $current_users = [];
       foreach($client->users as $user_item){
        $current_users[] = $user_item->id;
       }
        return view('admin.client.edit',[
            'client' => $client,
            'bx_group' => $bx24->find_group(),
             'user' =>$user->all(),
             'current_users' => $current_users
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

        $update_client = $client->update($request->all());
        $client->users()->sync($request->array_users);

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
