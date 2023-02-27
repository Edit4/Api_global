<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PostController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UserController;
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
//
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

   'middleware' => ['api', 'auth:api'],
   'prefix' => 'auth'

], function ($router) {

    Route::match(['get','post'],'login', [AuthController::class,'login'])->withoutMiddleware(['auth:api']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::match(['get','post'],'register', [RegisterController::class,'register'])->withoutMiddleware(['auth:api']);
    Route::post('refresh', [AuthController::class,'refresh'])->withoutMiddleware(['auth:api']);
    Route::get('user', [AuthController::class,'user']);
    Route::get('post', [PostController::class,'index']);
    Route::match(['get','post'],'post/create', [PostController::class,'store']);
    Route::match(['get','post'],'post/update/{id}', [PostController::class,'update']);
    Route::match(['get','post'],'post/delete/{id}', [PostController::class,'destroy']);
    Route::match(['get','post'],'post&search={id}', [PostController::class,'show'])->withoutMiddleware(['auth:api']);
    Route::match(['get','post'],'users', [UserController::class,'index']);
    Route::match(['get','post'],'users/update/{id}', [UserController::class,'update'])->withoutMiddleware(['auth:api']);
    Route::match(['get','post'],'users/delete/{id}', [UserController::class,'destroy'])->withoutMiddleware(['auth:api']);
    Route::match(['get','post'],'users&search={id}', [UserController::class,'show'])->withoutMiddleware(['auth:api']);
    Route::match(['get','post'],'send/feedback', [MailController::class,'sendFeedback'])->withoutMiddleware(['auth:api']);
    Route::match(['get','post'],'send/vacancy', [MailController::class,'sendVacancy'])->withoutMiddleware(['auth:api']);

});
