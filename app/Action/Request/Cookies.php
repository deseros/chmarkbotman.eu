<?php

namespace App\Action\Request;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class Cookies
{
    public function setCookie($name, mixed $data, $minutes){
        $response = new Response('Set Cookie');
        $response->withCookie(cookie($name, $data, $minutes));
        return $response;
    }
    public function getCookie(Request $request , $name){
        $value = $request->cookie($name);
        return $value;
     }
     public function deleteCookie($name){
        $response = new Response('Delete Cookie');
        $response->withCookie(cookie($name, ''));
        return $response;
     }

}