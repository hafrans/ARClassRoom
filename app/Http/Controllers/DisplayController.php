<?php

namespace App\Http\Controllers;

use App\SImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisplayController extends Controller
{
    //

    public function findTarget(Request $req,string $target){

        if (empty($target)){
            return [
                "code" => 1,
                "message" => "no target",
                "data" => null
            ];
        }

        $image = SImage::where("serial_id",$target)->first();
        if ($image == null){
            return [
                "code" => 1,
                "message" => "no target",
                "data" => null
            ];
        }else{
            $s3 = Storage::disk("s3");
            return [
              "code" => 0,
              "message" => "success",
              "data" => [
                  "targetId" => $target,
                  "kname" => $image->courseItem->name,
                  "iname" => $image->name,
                  "model" => $image->courseItem->model_path == null ? null : $s3->temporaryUrl($image->courseItem->model_path,now()->addMinutes(10)),
                  "video" => $image->courseItem->video_path == null ? null : $s3->temporaryUrl($image->courseItem->video_path,now()->addMinutes(10)),
                  "audio" => $image->courseItem->audio_path == null ? null : $s3->temporaryUrl($image->courseItem->audio_path,now()->addMinutes(10)),
                  "graph" => $image->courseItem->graph_path == null ? null : $s3->temporaryUrl($image->courseItem->graph_path,now()->addMinutes(10)),
                  "content" => $image->courseItem->content
              ]
            ];
        }


    }

    public function display(){
        return view("webar.index");
    }

}
