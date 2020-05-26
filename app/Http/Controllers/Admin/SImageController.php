<?php

namespace App\Http\Controllers\Admin;

use App\Api\EasyARClient;
use App\Http\Resources\SImageResource;
use App\SImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;

class SImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $req
     * @return Application|Factory|JsonResponse|View
     */
    public function index(Request $req)
    {

        if($req->ajax()){

            $pending = SImage::orderBy("created_at","desc");

            if ($req->has("target") && !empty($req->has("target"))){

                $pending->where("name","like","%{$req->target}%");
                $pending->orWhere("serial_id", $req->target);

            }

            $paginated =  $pending->paginate(20);

            $item = SImageResource::collection($paginated);

            return response()->json([
                "code" => 0,
                "msg" => 'OK',
                "count" => $paginated->total(),
                "data" => $item
            ]);

        }else{
            return view("admin.simage.index");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        return view("admin.simage.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
        $file = $request->file("img");
        dump(base64_encode($file->get()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SImage  $simage
     * @return Response
     */
    public function show(SImage $simage)
    {
        if($simage == null){
            abort(500,"图片不存在");
        }
        return response()->file("../storage/app/public/test.png");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SImage  $sImage
     * @return Response
     */
    public function edit(SImage $sImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SImage  $sImage
     * @return Response
     */
    public function update(Request $request, SImage $sImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SImage $simage
     * @param EasyARClient $client
     * @return JsonResponse
     */
    public function destroy(SImage $simage, EasyARClient $client)
    {
        try{
            $client->deleteObject($simage->serial_id);
            if($simage->delete()){
                return response()->json([
                    "code"=>0,
                    "message" => "success",
                    "data" => [
                        "id" => $simage->id,
                        "name" => $simage->name,
                    ]
                ]);
            }
        }catch (\Exception $e){
            return response()->json([
                "errors" => [
                    "name" => [$e->getMessage()]
                ]
            ],422);
        }
    }
}
