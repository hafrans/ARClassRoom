<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::any("/test","HomeController@test");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get("/checkstatus2","Admin\CloudImageController@checkStatusAjax");


Route::namespace("Admin")->name("admin.")->prefix("/admin")->middleware("auth:web")->group(function(){

    Route::get("/home","HomeController@home")->name("home");
    Route::get("/logout","HomeController@logout")->name("logout");
    Route::get("/dashboard","HomeController@dashboard")->name("dashboard");

    Route::get("/cloudImage/status","CloudImageController@checkStatus");

    Route::post("/upload/video","UploadController@video")->name("upload.video");
    Route::post("/upload/audio","UploadController@audio")->name("upload.audio");
    Route::post("/upload/model","UploadController@model")->name("upload.model");
    Route::post("/upload/image","UploadController@image")->name("upload.image");

    Route::resource("course","CourseController");
    Route::resource("courseItem","CourseItemController");
    Route::resource("simage","SImageController");

});
