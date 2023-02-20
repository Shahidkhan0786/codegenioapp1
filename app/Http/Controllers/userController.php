<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use Illuminate\Http\Request;
use App\Models\User;
// use Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class userController extends Controller
{
    //
    public function index(){
        $users = User::latest()->get();
        
        // for apis 
        $response = [
            'success' => true,
            'data'    => $users
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request){
        $input = $request->all();
        $request->validate([
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3',
            'email' => 'required|email',
            'DOB' => 'required',
            'password' => 'required',
            'userType' => 'required',
        ]);
        // dd($input['userType'] == 'student');
        DB::beginTransaction();
        try{
            $users = User::create($request->all());
            if(!$input['userType'] == 'student'){
                DB::commit();
            }
        }
        catch(\Exception $e){
            DB::rollback();
            echo 'Error: ' . $e->getMessage();
            $err = "Error in creating user ". $e->getMessage();
            return response()->json([
                "success" => false,
                 "message" => $err
            ] ,500);
        }

        if($input['userType'] == 'student'){
            $val=Validator::make($input,[
                'class'=> 'required'
            ]);
            if($val->fails()){DB::rollback(); return response()->json(["status"=> false, "message"=>"please enter a class"],400);}
            if(!$input['class']){ DB::rollback(); return response()->json(["status"=> false, "message"=>"please enter a class"],400);}
            $cls_id = $input['class'];
            $users->userType = $input['userType'];
            $stu = new Student();
            // $class= new Classes();
            try{
                $stu->user_id = $users->id;
                $stu->class_id = $input['class'];
                $stu->save();
                DB::commit();
            }
            catch(\Exception $e){
                DB::rollback();
                return response()->json([
                    'success' => false,
                    "message" =>  "Error in saveing student",
                ], 400);
        }
        }

        // response for apis 

        return response()->json([
            'success' => true,
            'data'    => $users
        ], 200);

    }

    // show single user 
    public function show(Request $request , User $user){
        // return view('user.show',compact('user'));
        return response()->json([
            'success' => true,
            'data'    => $user
        ], 200);
    }
    
    // edit user
    public function edit(Request $request, User $user){
        
        return view('user.edit',compact('user'));
    }

    public function update(Request $request ,User $user){
        $input = $request->all();
        // dd($request->all());
        $validator = Validator::make($input, [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'DOB'=>'required',
            
        ]);
   
        if($validator->fails()){
           
            return response()->json([
                'success' => false,
                "message" =>  $validator->errors(),
            ], 400);       
        }
       
        DB::beginTransaction();
        try{
            $user->firstName = $input['firstName'];
            $user->lastName = $input['lastName'];
            $user->email = $input['email'];
            $user->DOB = $input['DOB'];
            $user->save();
            DB::commit();
            // if(!$input['userType'] == 'student'){
            // DB::commit();
            // }
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                "message" =>  "Error in updateing user",
            ], 400);
        }
       
        
   
        return response()->json([
            'success' => true,
            "message" => "updated Successfully",
            'data'    => $user
        ], 200);


    }

    public function delete(User $user ){
        // dd($user);
        $res = $user->delete();
        // return redirect()->route('index')->with("success" , "User deleted successfully");
        return response()->json([
            'success' => true,
            'data'    => "Successfully deleted"
        ], 200);
    }




    

}
