<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Admin'], function(){
   Route::get('live-stream', ['as' => 'live-stream', 'uses' => 'StreamVideoController@index']);

   Route::get('player', function (){
      $video = 'uploads/test.mp4';
      $title = 'Play video';
      $mime = "video/mp4";
      return view( 'admin.stream-video')->with(compact('video', 'mime', 'title'));
   });

   Route::get('/video/{filename}', function ($filename){
       $videosDir = public_path('uploads');

       if(file_exists($filePath = $videosDir . '/' . $filename)){
           $stream = new \App\Helpers\VideoStream($filePath);

           return response()->stream(function() use ($stream){
               $stream->start();
           });
       }
   });
});


