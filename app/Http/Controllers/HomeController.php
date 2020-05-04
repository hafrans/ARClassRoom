<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function test(Request $req){
        Storage::disk("s3")->put("/name.txt","Hello Wolrd");
        $url = Storage::disk("s3")->temporaryUrl(
            'name.txt', now()->addMinutes(5)
        );

        $url2 = Storage::disk("s3")->url("name.txt");
        return [$url,$url2];
    }


}
