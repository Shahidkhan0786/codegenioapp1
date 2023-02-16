<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class commentController extends Controller
{
    //
    public function index(){
        $comments = Comment::all();

        return response()->json([
            "success" => true,
            "data" => $comments
        ] , 200);
    }


    public function createComment(Request $request , Post $post){
        // dump($request->all());
        // dd($post);
        
        if(!Auth::check()){
            return response()->json([
                "success" => false,
                "message" => "Please login first to create the comment.",
            ]);
        }

        $input = $request->all();
        $validator = Validator::make($input , [
            "content" => "required",  
        ]);

        if($validator->fails()){
           
            return response()->json([
                'success' => false,
                "message" =>  $validator->errors(),
            ], 400);       
        }

        $comment = new Comment();
        $comment->createdBy = Auth::user()->id;
        $comment->postId = $post->id;
        $comment->content = $input['content'];
        $comment->save();

        return response()->json([
            "success" => true,
            "data" => $comment
        ] , 200);
    }


    // update comments 
    // validaintion not applied in this update fun  
    public function updateComments(Request $request ,  $pid , $cid){
        $input = $request->all();
        $comment = Comment::find($cid);
        // dd(Post::find($pid)->comments->contains($cid));
        // if(!Post::find($pid)->comments->contains($cid)){
        //     return response()->json([
        //         'success' => false,
        //         "message" =>  "unauthorized",
        //     ], 400);
        // }
        $validator = Validator::make($input,[
            "content" => "required"
        ]);
            
        if($validator->fails()){
            return response()->json([
                'success' => false,
                "message" =>  $validator->errors(),
            ], 400);
        }

        $comment->content = $input['content'];
        $comment->save();
        return response()->json([
            "success" => true,
            "message" => "Updated Successfully"
        ] , 200);
    }




    // delete comments
    public function delComments(Comment $comment){
        if($comment->createdBy != Auth::id()){
            return response()->json([
                'success' => false,
                "message" =>  "not authorized",
            ], 400);
        }

        $comment->delete();

        return response()->json([
            "success" => true,
             "message" => "deleted successfully",
        ], 200);
    }
    
}
