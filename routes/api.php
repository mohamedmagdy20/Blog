<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);


Route::group(['controller'=>PostController::class,'prefix'=>'posts'],function()
{
    Route::get('/','index');
    Route::get('/{id}','getPost');
});


Route::group(['controller'=>ReplyController::class,'prefix'=>'comments'],function()
{
    Route::get('/{id}/replies','getAllReply');
});

Route::group(['controller'=>CommentController::class,'prefix'=>'posts'],function()
{
    Route::get('/{id}/comments','getComment');
});


Route::group(['middleware'=>'auth:api'],function(){
    Route::delete('logout',[AuthController::class,'logout']);

    Route::group(['controller'=>PostController::class,'prefix'=>'posts'],function()
    {
        Route::post('/','store');
        Route::delete('/{id}','delete');
    });

    
    Route::group(['controller'=>CommentController::class,'prefix'=>'posts'],function()
    {
        Route::post('/{id}/comments','store');
        Route::delete('/comments/{id}','delete');

    });

    Route::group(['controller'=>ReplyController::class,'prefix'=>'comment'],function()
    {
        Route::post('/{id}/replies','store');
        Route::delete('/replies/{id}','delete');

    });
});