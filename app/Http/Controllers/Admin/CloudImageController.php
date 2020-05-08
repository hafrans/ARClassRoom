<?php

namespace App\Http\Controllers\Admin;

use App\Api\EasyARClient;
use App\Api\EasyARClientSdkCRS;
use App\Course;
use App\CourseItem;
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


    public function bindImage(Request $req, SImage $image){

        if ($req->ajax()){

        }else{
            return view("admin.cloudimage.bind",[
                "simage" => $image,
            ]);
        }

    }

    private function findObject(Request $req, $class){
        $pending = $class::orderBy("created_at");

        if($req->has("name") || !empty($req->name)){
            $pending->where("name","like","%$req->name%");
        }

        if ($req->has("course") && !empty($req->course)){
            $course = Course::where("name",$req->course)->first();

            if($course != null){
                $pending->where("course_id",$course->id);
            }else{
                return [
                    "code" => 1, "message" => "课程不存在", "data" => []
                ];
            }
        }

        $result = $pending->select(["id","name"])->limit(5)->get();
        return [
            "code" => 0, "message" => "success", "data" => $result
        ];
    }

    public function findCourse(Request $req){

        return $this->findObject($req,Course::class);

    }


    public function findCourseItem(Request $req){
        return $this->findObject($req,CourseItem::class);
    }


}
