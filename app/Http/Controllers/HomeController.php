<?php

namespace App\Http\Controllers;

use App\Api\EasyARClientSdkCRS;
use App\Http\Resources\CourseItem;
use App\Http\Resources\CourseItemResource;
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


    public function test(Request $req, EasyARClientSdkCRS $client){

        dump($client);
        dump($client->ping());
        dump($client->targetsCount());
        dump($client->targetsV3());

    }


}
