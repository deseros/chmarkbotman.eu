<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function perform(Cookie $cookie)
    {
        
        Session::flush();
        setcookie('tg_user', '');
        Auth::logout();
        return redirect('/');
    }
}
