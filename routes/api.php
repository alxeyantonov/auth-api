<?php

use Illuminate\Http\Request;

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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {
    Route::post('register', "ApiRegistrationController@registration");
    Route::group(['middleware' => 'auth:api'], function () {
        Route::put('post', "PostController@addPost");
        Route::put('post/{post}/reply', "PostController@addReply");
        Route::get('posts', "PostController@getPosts")->name('posts');
    });

});