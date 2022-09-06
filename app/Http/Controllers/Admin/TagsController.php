<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\Tags;

class TagsController extends Controller
{ 
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Tags $tags)
    {
        return view('admin.tags.index',[
            'tags' => $tags->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Tags $tags , Request $request)
    {
        
        $this->validate($request, [
            'name_tags' => 'required|string|min:3',
            'type_tags' => 'string',
             'notif_text' => 'max:960',
        ]);
        $tags->create($request->all());
        return redirect()->back()->withSuccess('Тег добавлен');
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
    public function edit(Tags $tags, $id)
    {
        return view('admin.tags.edit', [
            'tags' => $tags->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Tags $tags, Request $request, $id)
    {
        $this->validate($request, [
            'name_tags' => 'required|string|min:3',
            'type_tags' => 'string',
            'notif_text' => 'max:960',
        ]);
        $tags->find($id)->update($request->all());
        return redirect()->back()->withSuccess('Тег обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tags $tags, $id)
    {
        $tags->find($id)->delete();
        return redirect()->back()->withSuccess('Тег удален');
    }
}
