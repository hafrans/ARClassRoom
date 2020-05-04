<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseItem;
use App\Http\Resources\CourseItemResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(Request $req)
    {
        //
        if(!$req->has("course")){
            abort("500","No Course Provided.");
        }
        if($req->ajax()){
            $course = Course::find($req->course);
            if ($course == null){
                return response()->json([
                    "code" => 0,
                    "msg" => 'empty',
                    "count" => 0,
                    "data" => []
                ]);
            }// null

            $query = CourseItem::where("course_id",$course->id);
            if($req->has("name")){
                $query = $query->whereRaw("name like ?","%".$req->name."%");
            }
            $paginated = $query->paginate(20);
            $item = CourseItemResource::collection($paginated);

            return response()->json([
                "code" => 0,
                "msg" => 'OK',
                "count" => $paginated->total(),
                "data" => $item
            ]);
        }
        return view("admin.courseitem.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CourseItem  $courseItem
     * @return \Illuminate\Http\Response
     */
    public function show(CourseItem $courseItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CourseItem  $courseItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseItem $courseItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CourseItem  $courseItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CourseItem $courseItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CourseItem  $courseItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CourseItem $courseItem)
    {
        try{
            if($courseItem->delete()){
                return response()->json([
                    "code"=>0,
                    "message" => "success",
                    "data" => [
                        "id" => $courseItem->id,
                        "name" => $courseItem->name,
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
