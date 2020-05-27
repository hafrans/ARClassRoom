<?php

namespace App\Http\Controllers\Admin;

use App\Api\EasyARClient;
use App\Http\Requests\SImageRequest;
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
use Illuminate\Support\Facades\Storage;
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

        if ($req->ajax()) {

            $pending = SImage::orderBy("created_at", "desc");

            if ($req->has("target") && !empty($req->has("target"))) {

                $pending->where("name", "like", "%{$req->target}%");
                $pending->orWhere("serial_id", $req->target);

            }

            $paginated = $pending->paginate(20);

            $item = SImageResource::collection($paginated);

            return response()->json([
                "code" => 0,
                "msg" => 'OK',
                "count" => $paginated->total(),
                "data" => $item
            ]);

        } else {
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
     * @param SImageRequest $request
     * @param EasyARClient $client
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(SImageRequest $request, EasyARClient $client)
    {
        $valiadated = $request->validated();

        if (!Storage::exists($valiadated["image"])) {
            return response()->json([
                "errors" => [
                    "name" => ["目标图片不存在"]
                ]
            ], 422);
        }

        $encodedImage = base64_encode(Storage::get($valiadated["image"]));

        try {
            $result = $client->createObject($encodedImage, $valiadated["name"], $valiadated["meta"] ?: "None", "1", strval($valiadated["size"]));
            if ($result){

                $simage = SImage::create(["name" => $result->name,
                                         "serial_id" => $result->targetId,
                                         "path" => $valiadated["image"],
                                         "meta" => $result->meta]);

                return response()->json([
                    "code" => 0,
                    "message" => "success",
                    "data" => [
                        "id" => $simage->id,
                        "name" => $simage->name,
                        "meta" => $simage->meta,
                        "target" => $simage->serial_id,
                    ]
                ]);


            }else{
                return response()->json([
                    "errors" => [
                        "name" => [$e->getMessage()]
                    ]
                ], 422);
            }

        }catch (\Exception $e){

           if (strstr($e->getMessage(),"419") !== false){
               return response()->json([
                   "errors" => [
                       "name" => ["识别库中存在类似图！"]
                   ]
               ], 422);
           }else{
               return response()->json([
                   "errors" => [
                       "name" => [$e->getMessage()]
                   ]
               ], 422);
           }

        }


    }

    /**
     * Display the specified resource.
     *
     * @param \App\SImage $simage
     * @return Response
     */
    public function show(SImage $simage)
    {
        if ($simage == null) {
            abort(500, "图片不存在");
        }
        return response()->file("../storage/app/".$simage->path);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\SImage $sImage
     * @return Response
     */
    public function edit(SImage $sImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\SImage $sImage
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
        try {
            $client->deleteObject($simage->serial_id);
            if ($simage->delete()) {
                return response()->json([
                    "code" => 0,
                    "message" => "success",
                    "data" => [
                        "id" => $simage->id,
                        "name" => $simage->name,
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "errors" => [
                    "name" => [$e->getMessage()]
                ]
            ], 422);
        }
    }
}
