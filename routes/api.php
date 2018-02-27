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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
    Route::post('login', ['as' => 'login', 'uses' => 'LoginController@login']);
    Route::post('register', ['as' => 'user.register', 'uses' => 'UserController@register']);
    Route::group(['prefix' => 'user', 'middleware' => 'jwt-auth'], function () {
        Route::post('update', ['as' => 'user.update', 'uses' => 'UserController@update']);
    });

    Route::group(['prefix' => 'todo', 'middleware' => 'jwt-auth'], function () {
        Route::get('/', ['as' => 'todo.lists', 'uses' => 'TodoController@index']);
    });

    Route::post('upload', ['as' => 'upload', 'uses' => 'UploadController@upload']);

    Route::group(['prefix' => 's3-config'], function(){
       Route::get('/', ['as' => 'helper.s3-config' , 'uses' => 'HelperController@getS3Config']);
    });
});
