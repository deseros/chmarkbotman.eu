<?php

namespace App\Http\Controllers\Admin\Hooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class ClientHooks extends Controller
{
    public function find_group(){
        
        $use_bx = new Bitrix24API(env('BX_WEBHOOK')); 
        $contain = []; 
        $generator = $use_bx->group_list();
       foreach ($generator as $users) {
           
              $contain[] = $users;
    
       }
       return $contain;
    
    
    }

    
}
