<?php

  

namespace App\Http\Controllers;

  

use BotMan\BotMan\BotMan;

use Illuminate\Http\Request;




class BotManController extends Controller

{   
  
    public function handle()

    {
        $botman = app('botman');
     
        $botman->hears('/start', 'App\Http\Controllers\Botman\Hooks@start');
        
        $botman->hears('Начать ввод обращения', 'App\Http\Controllers\Botman\Hooks@start_ticket');
           
        $botman->hears('Завершить отправку', 'App\Http\Controllers\Botman\Hooks@complete_ticket');

        $botman->receivesImages('App\Http\Controllers\Botman\MediaHooks@parse_image'); 

        $botman->receivesFiles('App\Http\Controllers\Botman\MediaHooks@parse_document'); 

        $botman->fallback('App\Http\Controllers\Botman\Hooks@default');

        $botman->listen();
    }
   
}