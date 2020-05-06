<?php

namespace App\Http\Controllers\Admin;

use App\Api\EasyARClient;
use App\Api\EasyARClientSdkCRS;
use App\Http\Controllers\Controller;
use App\SImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CloudImageController extends Controller
{
    //

    public function index()
    {


    }


    public function checkStatusAjax(Request $req, EasyARClient $client)
    {

        if (!$req->has("id") || !is_numeric($req->id)) {
            abort(500, "s image id not found");
        }

        $simage = SImage::find($req->id);

        if($simage == null){
            return [
             "code" => 2,
             "message" => "图片不存在",
            ];
        }

        $targetId = $simage->serial_id;

        $result = $client->checkStatus($targetId);
        if(is_numeric($result)){
            return [
                "code" => 3,
                "rmc" => $result,
                "message" => "远程过程调用失败",
            ];
        }else{
            return [
                "code" => 0,
                "message" => "success",
                "data" => $result,
            ];
        }

    }

    public function checkStatus(Request $req, EasyARClient $client){


        if (!$req->has("id") || !is_numeric($req->id)) {
            abort(500, "未规定图片必要信息");
        }

        $simage = SImage::find($req->id) or abort(500,"图片不存在");

        $targetId = $simage->serial_id;
        $result = $client->checkStatus($targetId);
        if(is_numeric($result)){
            abort(500,"云识别库中没有该图片！");
        }else{
            return view("admin.cloudimage.status",[
                "result" => $result,
                "simage" => $simage,
            ]);
        }
    }

}
