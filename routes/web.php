<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\postController;    

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/user' ,[userController ::class, 'index']);


Route::prefix('/users')->controller(userController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/create', 'store')->name('storeUser');
    Route::get('/show/{user}','show')->name('users.show');
    Route::get('/edit/{user}', 'edit')->name('users.edit');
    Route::put('/update/{user}', 'update')->name('users.update');
    Route::delete('/delete/{user}', 'delete')->name('users.destroy');
});


// posts routes 
Route::prefix('/posts')->controller(postController::class)->group(function () {
    Route::get('/', 'index')->name('posts.index');
    Route::post('/create', 'store')->name('post.create')->middleware('auth');
    Route::get('/show/{user}','show')->name('posts.show');
    Route::get('/edit/{user}', 'edit')->name('posts.edit');
    Route::put('/update/{user}', 'update')->name('posts.update');
    Route::delete('/delete/{user}', 'delete')->name('posts.destroy');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
