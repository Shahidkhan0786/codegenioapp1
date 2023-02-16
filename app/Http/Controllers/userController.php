<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class userController extends Controller
{
    //
    public function index(){
        $users = User::latest()->paginate(5);
        // dd($users);
        return view('user.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function store(Request $request){
        $request->validate([
            'firstName' => 'required|min:3',
            'lastName' => 'required|min:3',
            'email' => 'required|email',
            'DOB' => 'required',
            'password' => 'required',
            'userType' => 'required',
        ]);

        // dd($request->all());
        // dump($request->all());
        User::create($request->all());
        return redirect()->route('index')
                        ->with('success','User created successfully.');
    }

    // show single user 
    public function show(Request $request , User $user){
        // dump($request->id);
        // dd($user);
        return view('user.show',compact('user'));
    }
    
    // edit user
    public function edit(Request $request, User $user){
        
        return view('user.edit',compact('user'));
    }

    public function update(Request $request ,User $user){
        // $user = $request->user();
        $request->validate([
            'firstName' =>'required',
            'lastName' =>'required',
            'email' =>'required', 
            'DOB' =>'required',
        ]);
        $user->update($request->all());
    
        return redirect()->route('index')
                        ->with('success','User updated successfully');
    }

    public function delete(User $user ){
        // dd($user);
        $user->delete();
        return redirect()->route('index')->with("success" , "User deleted successfully");
    }

}
