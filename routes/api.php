<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\postController;  
use App\Http\Controllers\authController;
use App\Http\Controllers\commentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




//register new user
Route::post('/v1/create-account', [authController::class, 'createAccount']);
//login user
Route::post('/v1/signin', [authController::class, 'signin']);

//using middleware
// auth routes  a routes where we need token 
Route::middleware('auth:sanctum')->prefix('/v1')->group(function () {
    Route::post('/sign-out', [authController::class, 'signout']);

    //for users 
    Route::get("/user/myposts" , [postController::class , 'myPosts']);

    // for posts 
    Route::put('/update/{post}', [postController::class , 'update']);
    Route::delete('/delete/{post}',[postController::class , 'deletePost']);
});




Route::prefix('/v1/users')->controller(userController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('storeUser');
    Route::get('/show/{user}','show')->name('users.show');  //pass id and get user
    // Route::get('/edit/{user}', 'edit')->name('users.edit');
    Route::put('/update/{user}', 'update')->name('users.update');
    Route::delete('/delete/{user}', 'delete')->name('users.destroy');

    // get user posts 
    Route::put('/update/{user}', 'update')->name('posts.update');
});


// posts routes 
Route::prefix('/v1/posts')->controller(postController::class)->group(function () {
    Route::get('/', 'index')->name('posts.index');
    Route::post('/create', 'store')->name('post.create')->middleware('auth:sanctum');
    // Route::get('/show/{user}','show')->name('posts.show');
    // Route::get('/edit/{user}', 'edit')->name('posts.edit');
    // Route::put('/update/{user}', 'update')->name('posts.update');
    
});



// routes for comments

Route::prefix('/v1/comments')->controller(commentController::class)->group(function(){
    Route::get("/" , "index");
    
});

// comments auth routes 
Route::middleware("auth:sanctum")->prefix('/v1/comment')->controller(commentController::class)->group(function(){
    Route::post("/create/{post}" , "createComment");
    Route::put("/update/{pid}/{cid}" , "updateComments");
    Route::put("/del/{cid}" , "delComments");
});