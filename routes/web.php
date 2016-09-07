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

// Facebook Login Route
Route::get('/request', 'RequestController@request');
Route::get('/request/redirect', 'RequestController@redirect');
Route::get('/request/callback', 'RequestController@callback');
Route::get('/request/complete', 'RequestController@complete');

Route::get('/home', 'HomeController@index');
Route::get('/user', 'UserController@index');
Route::post('/user', 'UserController@store');

Route::get('/access', 'AccessController@index');
