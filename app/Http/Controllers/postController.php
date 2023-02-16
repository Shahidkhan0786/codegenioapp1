<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class postController extends Controller
{
    //
    public function index(Request $request){
        $posts = Post::all();
        return response()->json([
            'success' => true,
            'data'    => $posts
        ], 200);
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
            return response()->json([
                'success' => true,
                "message" => "Post created successfully",
                'data'  => $post
            ], 200);
            // return redirect()->route('posts.index')->with('success', 'Post created successfully');
        }
        return response()->json([
            'success' => false,
            "message" => "Please Login first to create post",
        ], 400);
    }


    // update post 

    public function update(Request $request , Post $post){

        $input = $request->all();
        // dd($input);
        $validator = Validator::make($input , [
            'content' => 'required',
        ]);
   
        if($validator->fails()){
           
            return response()->json([
                'success' => false,
                "message" =>  $validator->errors(),
            ], 400);       
        }
        // dump($post);
        // dd(Auth::id());
        if($post->createdBy != Auth::id()){
            return response()->json([
                'success' => false,
                "message" =>  "Please provide correct id",
            ], 400);
        }
        $post->content = $input['content'];
        $post->save();
   
        return response()->json([
            'success' => true,
            "message" => "updated Successfully",
            'data'    => $post
        ], 200);

    }


    public function deletePost(Request $request , Post $post){
        if($post->createdBy != Auth::id()){
            return response()->json([
                'success' => false,
                "message" =>  "Please provide correct id",
            ], 400);
        }

        $post->delete();
        return response()->json([
            'success' => true,
            "message" =>  "deleted successfully",
        ], 400);
    }

    public function myPosts(Request $request){
        // dd("shshid");
        $id = Auth::user()->id;
        // $posts = Post::where('createdBy', '=', $id)->get();
        // or 
        $posts = User::find($id)->posts;
       
        return response()->json([
            'success' => true,
            "data" => $posts,
        ], 200);
    }

}
