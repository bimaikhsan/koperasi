<?php

use App\Http\Controllers\API\PostsController;
use App\Http\Controllers\API\UraianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;

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


Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::get('logout', [UserController::class, 'logout']);

Route::group(['prefix' => 'posts'], function() {
    Route::get('/', [PostsController::class,'index']);
    Route::post('add', [PostsController::class,'add']);
    Route::post('cari', [PostsController::class,'cariData']);
    Route::post('update/{id}', [PostsController::class,'update']);
    Route::get('edit/{id}', [PostsController::class,'edit']);
    Route::delete('delete/{id}', [PostsController::class,'delete']);
    Route::get('selectnama/{nama}', [PostsController::class,'selectname']);
});

Route::group(['prefix' => 'uraian'], function() {
    Route::get('/', [UraianController::class,'index']);
    Route::post('add', [UraianController::class,'add']);
    Route::post('update/{id}', [UraianController::class,'update']);
    Route::get('edit/{id}', [UraianController::class,'edit']);
    Route::delete('delete/{id}', [UraianController::class,'delete']);
    Route::get('selectnama', [UraianController::class,'selectname']);

});
