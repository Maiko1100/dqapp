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



Route::get('adres/upload', 'AdresController@Upload');

Route::post('adres/search', 'AdresController@search');
Route::post('adres/brief', 'AdresController@brief');
Route::post('adres/email', 'AdresController@email');

Route::resource('adres', 'AdresController');





