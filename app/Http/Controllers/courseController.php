<?php

namespace App\Http\Controllers;

use App\Models\Course as ModelsCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class courseController extends Controller
{
    //

    public function index(){
        $course = ModelsCourse::all();
        // dd($course);
        return response()->json([
            'status' => true,
            'data' => $course
        ], 200);   
    }


    // add course 

    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input , [
            'title'=> 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 500);
        };
        DB::beginTransaction();
        try{
            $course = ModelsCourse::create($request->all());
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $err = $e->getMessage();
            echo $err;
            return response()->json([
                'status' => false,
                'error' =>$err
            ], 500);
        }

        return response()->json([
            'status' => true,
            'data' =>$course 
        ], 200);
    }


    public function updateCourse(Request $request , ModelsCourse $course){
        if(is_null($course)){
            return response()->json([
                'status'=> false,
                'message' => "Course does,t exists"
            ], 404);
        }
        if (!count($request->all())) {
            return response()->json([
                'status' => false,
                'error' => "Empty Request not allowed to update"
            ], 500);
        }
        $input = $request->all();
        $validator = Validator::make($input , [
            'title'=> 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 500);
        };


        DB::beginTransaction();
        try{
            // $course->update(request()->intersect('title', 'description', 'status'));
            $course->title = $input['title'];
            $course->description = $input['description'];
            $course->status = $input['status'];
            $course->save();
            DB::commit();
        }
        catch(\Exception $e){
            DB::rollBack();
            $course = null;
            echo $e->getMessage();
        }
        
        if(is_null($course)){
            return response()->json([
                'status'=> false,
                'message' => "Error in Course update",
                'error' => $e->getMessage()
            ], 404);
        }
        
        return response()->json([
            'status'=> true,
            'message' => "Course update Successfully"
        ], 200);
       
    }


    // del course 

    public function delCourse(Request $request , ModelsCourse $course){
        if(is_null($course)){
            return response()->json([
                'status'=> false,
                'message' => "Error in Course update please provide correct id"
            ], 404);
        }
        else{
            DB::beginTransaction();
            try{
                $course->delete();
                DB::commit();
            }
            catch(\Exception $e){
                DB::rollBack();
                $course = null;
            }
        }

        if(is_null($course)){
            return response()->json([
                'status'=> false,
                'message' => "Error in Course deletion",
                'error' => $e->getMessage()
            ], 404);
        }


        return response()->json([
            'status'=> true,
            'message' => "Course deleted Successfully"
        ], 200);


    }



    // list of course classes 

    public function listofclasses($id){
        // dump("dddd");
        $cwc = ModelsCourse::find($id)->classes;
   
        return response()->json([
            "status"=>false,
            'data'=> $cwc
        ],200);
    }
}
