<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\File;
use GuzzleHttp\Client;

class TgSettingsController extends Controller
{


    public function index(){
       
       
         
        return view('admin.tgsetting.index', [
       
        ]);
    }
    public function update_setting(Request $request){
        $path = base_path('.env');

        if (file_exists($path)) {
            if($request->has('name_app')){
                $new_app_name = str_replace(' ', '&nbsp', $request->name_app);
           file_put_contents($path, str_replace(
                'TESTOR_NAME='.env('TESTOR_NAME'), 'TESTOR_NAME='.$new_app_name, file_get_contents($path)
            ));
        }
            if($request->has('token_bot_main')){
           file_put_contents($path, str_replace(
                'TELEGRAM_BOT_TOKEN='.env('TELEGRAM_BOT_TOKEN'), 'TELEGRAM_BOT_TOKEN='.$request->token_bot_main, file_get_contents($path)
            ));
            }
        if($request->has('token_bot_comment')){
            file_put_contents($path, str_replace(
                'TELEGRAM_BOT_TOKEN_COMMENT ='.env('TELEGRAM_BOT_TOKEN_COMMENT'), 'TELEGRAM_BOT_TOKEN_COMMENT='.$request->token_bot_comment, file_get_contents($path)
            ));
        }

        }
        return redirect()->back()->withSuccess('Настройки обновлены');
    }
   
}