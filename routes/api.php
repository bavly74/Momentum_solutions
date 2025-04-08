<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserAuth::class, 'register']);
Route::post('/login',[UserAuth::class , 'login'] ) ;
Route::middleware('auth:sanctum')->post('/logout', [UserAuth::class, 'logout']);

Route::get('/posts',[PostController::class ,'index'])->middleware('auth:sanctum') ;
Route::post('/store/post',[PostController::class ,'store'])->middleware('auth:sanctum') ;
Route::put('/post/{id}', [PostController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/post/delete/{id}',[PostController::class ,'delete'])->middleware('auth:sanctum') ;
