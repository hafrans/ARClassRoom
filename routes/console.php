<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');


Artisan::command("easyar:migrate",function(\App\Api\EasyARClient $client){

    $this->comment("The system is going to migrate easyar assets...");
    $images = \App\SImage::all();
    $count = count($images);
    $this->comment("There are $count ar images ");
    if ($this->confirm("Are you ready to migrate files?")){
        foreach ($images as $im){
            $this->comment("migrating $im->name ...");
            $result = false;

            try{
                $result = $client->getInfo($im->serial_id);
            }catch(Exception $e){
//                $this->comment("migrate failed ".$e->getMessage()."code:".$e->getCode());
            }



            try{
                if ($result){
                    $this->comment("can not migrate duplicated image $im->name ...");
                }else{
                    if(Storage::exists($im->path)){
                        $encodedImage = base64_encode(Storage::get($im->path));
                        $res =  $client->createObject($encodedImage,$im->name,$im->meta,"1","20");

                        if ($res){
                            $im->serial_id = $res->targetId;
                            $im->save();
                            $this->comment("$im->name migrated.");
                        }else{
                            $this->comment("$im->name not migrated.");
                        }

                    }else{
                        $this->comment("can not migrate duplicated image $im->name , path $im->path not found");
                    }

                }

            }catch(Exception $e){
                $this->comment("migrate failed ".$e->getMessage()."code:".$e->getCode());
            }
        }
    }else{
        $this->comment("Abort.");
    }

});
