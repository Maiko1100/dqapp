<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index');



//Route::get('upload', 'UploadController@index');

Route::resource('upload', 'UploadController');

Route::get('adres/brief', 'AdresController@maakBrief');



Route::post('adres/search', 'AdresController@search');
Route::get('adres/test', 'AdresController@test');

Route::post('mail', 'AdresController@mail');
Route::post('brief', 'AdresController@brief');

Route::get('/download/{file}', 'DownloadsController@download');


Route::resource('adres', 'AdresController');





