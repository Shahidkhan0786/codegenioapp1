<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class authController extends Controller
{
    //
     //this method adds new users
     public function createAccount(Request $request)
     {
        // dd("shahid");
        $attr = $request->validate([
            'firstName' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);
         $user = User::create([
             'firstName' => $attr['firstName'],
             'password' => bcrypt($attr['password']),
             'email' => $attr['email']
         ]);
        $token =  $user->createToken('tokens')->plainTextToken;
        return response()->json([
            'success' => true,
            "message" => "Successfully Registered",
            'token'    => $token
        ], 200);
     }

     //use this method to signin users
     public function signin(Request $request)
     {
         $attr = $request->validate([
             'email' => 'required|string|email|',
             'password' => 'required|string|min:6'
         ]);
 
         if (!Auth::attempt($attr)) {
             return response()->json([
                'success' => false,
                "message" => "Please provide a valid credentials"
            ], 400);
         }
         $token = auth()->user()->createToken('API Token')->plainTextToken;
         return response()->json([
            'success' => true,
            "message" => "Successfully Login",
            'token'  => $token
        ], 200);
     }
 
     // this method signs out users by removing tokens
     public function signout()
     {
         auth()->user()->tokens()->delete();
 
         return response()->json([
            'success' => true,
            "message" => "Successfully Logout",
        ], 200);
     }
}
