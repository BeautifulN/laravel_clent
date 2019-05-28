<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;

class SignController extends Controller
{
    public function sign()
    {
        return view('login.sign');
    }

    public function sign_do(Request $request)
    {
//        $id = $request->input('id');
        $time = date('Y-m-d');

        $id = Auth::id();
        $key = 'sign'.$time;
        $res = Redis::setbit($key,$id,1);
        header('Refresh:3;url=/sign_doo');
    }

    public function sign_doo(Request $request)
    {
        $time = date('Y-m-d');
        $key = 'sign'.$time;
        $arr = Redis::bitcount($key);
        return view('login.sign_do',['arr'=>$arr]);
    }
}
