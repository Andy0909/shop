<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    public function loginToken(Request $request)
    {
        Session::put('token',$request['token']);
        Session::put('name',$request['name']);
    }

    public function logout(Request $request)
    {
        if($request['userStatus'] == 0){
            Session::flush();
        }
    }
}
