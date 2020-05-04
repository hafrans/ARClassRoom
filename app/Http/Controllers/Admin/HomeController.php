<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    //

    public function home(){
        return view("admin.base");
    }


    public function dashboard(){
        return view("admin.dashboard");
    }


    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect("/");
    }

}
