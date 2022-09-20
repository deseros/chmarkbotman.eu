<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\File;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Client;
use App\Models\Tags;

class TgSettingsController extends Controller
{
    use HasRoles;

    public function index(Tags $tags){

        Log::info(Client::find(16)->users);
        Log::info($tags->getTaskStatus());
        //Log::info(User::find(Auth::user()->id)->hasRole('admin'));
        return view('admin.tgsetting.index', [
       
        ]);
        
    }
    public function update_setting(Request $request){
        $path = base_path('.env');

        if (file_exists($path)) {
            
                $new_app_name = str_replace(' ', '&nbsp', $request->name_app);
           file_put_contents($path, str_replace(
                'APP_URL='.env('APP_URL'), 'APP_URL='.$new_app_name, file_get_contents($path)
            ));
        
        
           file_put_contents($path, str_replace(
                'TELEGRAM_BOT_TOKEN='.env('TELEGRAM_BOT_TOKEN'), 'TELEGRAM_BOT_TOKEN='.$request->token_bot_main, file_get_contents($path)
            ));
            
       
            file_put_contents($path, str_replace(
                'TELEGRAM_BOT_TOKEN_COMMENT ='.env('TELEGRAM_BOT_TOKEN_COMMENT'), 'TELEGRAM_BOT_TOKEN_COMMENT='.$request->token_bot_comment, file_get_contents($path)
            ));
            file_put_contents($path, str_replace(
                'BX_WEBHOOK='.env('BX_WEBHOOK'), 'BX_WEBHOOK='.$request->bx_webhook, file_get_contents($path)
            ));

        }
        return redirect()->back()->withSuccess('Настройки обновлены');
    }
   
}