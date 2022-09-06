<?php

namespace App\Http\Controllers\Admin\Hooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bitrix24\Bitrix24API;
use App\Bitrix24\Bitrix24APIException;
use Illuminate\Support\Facades\Log;

class UserHooks extends Controller
{
   public function find_user(){    
     $use_bx = new Bitrix24API(env('BX_WEBHOOK')); 
     $contain = []; 
     $generator = $use_bx->getUsers(
        [ 'ACTIVE' => true ],
        $order = 'ASC',
        $sort = 'NAME'
    );
    foreach ($generator as $users) {
        foreach($users as $user) {
           $contain[] = $user;
        }
    }
    return $contain;
   }
}
