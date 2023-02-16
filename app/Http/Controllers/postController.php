<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
class postController extends Controller
{
    //
    public function index(Request $request){
        $posts = Post::all();
        // dump(Auth::user()->id);
        // dd($posts);
        // $user = $posts->user->firstName;
        // dd($posts);
        return view('posts.index',compact('posts'));
    }


    public function store(Request $request){
        $request->validate([
            'content' =>'required|min:10',
        ]);
        if(Auth::check()){
            $post = new Post();
            $post->content = $request->content;
            $post->createdBy = Auth::user()->id;
            $post->save();
            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }



    public function myPosts(Request $request){
        $id = Auth::user()->id;
        $posts = Post::where('createdBy', '=', $id)->get();  
        dd($posts);
    }

}
