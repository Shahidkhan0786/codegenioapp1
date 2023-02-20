<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;  
class classController extends Controller
{
    //
    public function index(){
        $classes = Classes::all();

        return response()->json([
            'status'=> true,
            'data' => $classes
        ],200);
    }

    // create class
    public function createClass(Request $request){
        if(!$request->all()){
            return response()->json([
                'status'=> false,
                'message'=> "empty request not allowed" 
            ], 404);
        }
        $input = $request->all();
        $validator = Validator::make($input , [
            "name"=> "required",
            "day"=> "required",
            "starttime" => "required",
            "endtime"=> "required",
            "course_id"=> "required"
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> false,
                'message'=> $validator->errors() 
            ], 404);
        }
        // dump("start");
        DB::beginTransaction();
        try{
            $course_id = $input["course_id"];
            $course = Course::find($course_id);
            $class = new Classes();
            $class->name = $input["name"];
            $class->day = $input["day"];
            $class->course_id  = $input["course_id"];
            $class->starttime = $input["starttime"];
            $class->endtime = $input["endtime"];
            $course->classes()->save($class);
            // $class->save();
            DB::commit();
        }   
        catch(\Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=> false,
                'message'=> $e->getMessage() 
            ], 404);
        }

        return response()->json([
            'status'=> true,
            'message'=> "Class Successfully Created",
            "data" => $class 
        ], 200);
    }
}
