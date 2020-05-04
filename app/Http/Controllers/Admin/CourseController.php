<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $req
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req): Object
    {

        if ($req->ajax()) {
            $result = [];
            if ($req->has("name")) {
                $result = Course::where("name", "like", "%" . $req->name . "%")->paginate(20);
            } else {
                $result = Course::paginate(20);
            }


            return response()->json([
                "code" => 0,
                "msg" => 'OK',
                "count" => $result->total(),
                "data" => $result->items()

            ]);
        } else {

            $req->flash();
            return view("admin.course.index");
        }

        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //

        $req->flash();
        return view("admin.course.create");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
       $data = $request->validated();

       try{

           $course = \App\Course::create($data);

           return response()->json([
               "code"=>0,
               "message" => "success",
               "data" => [
                   "id" => $course->id,
                   "name" => $course->name,
               ]
           ]);


       }catch (\Exception $e){
           return response()->json([
               "errors" => [
                   "name" => [$e->getMessage()]
               ]
           ],422);
       }

       return response()->json($data);


    }

    /**
     * Display the specified resource.
     *
     * @param \App\Course $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Course $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Course $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Course $course
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Course $course)
    {
        try{
            if($course->delete()){
                return response()->json([
                    "code"=>0,
                    "message" => "success",
                    "data" => [
                        "id" => $course->id,
                        "name" => $course->name,
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
