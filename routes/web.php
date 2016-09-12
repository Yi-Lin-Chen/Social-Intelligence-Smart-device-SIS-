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

// Enter
// 讓雷包取回自己所有的 QR Code，限 FB 認證免登入
Route::get('/enter' , 'EnterController@index');
Route::get('/enter/redirect', 'EnterController@redirect');
Route::get('/enter/callback', 'EnterController@callback');


// Facebook Login Route
Route::get('/request', 'RequestController@request');
Route::get('/request/redirect', 'RequestController@redirect');
Route::get('/request/callback', 'RequestController@callback');

// Manager Approval
Route::get('/approval', 'ApprovalController@list');
Route::get('/approval/{id}', 'ApprovalController@show');
Route::get('/approval/grant/{id}', 'ApprovalController@grant');
Route::get('/approval/deny/{id}', 'ApprovalController@deny');
Route::delete('/approval/{id}' , 'ApprovalController@destroy');

// Direct Control
Route::get('/home' , 'HomeController@index');
Route::get('/home/door/{query}' , 'HomeController@door');

Route::get('/user' , 'UserController@index');
Route::post('/user/update/{id}' , 'UserController@update');
Route::post('/user' , 'UserController@store');
Route::delete('/user/{id}' , 'UserController@destroy');

Route::get('/access' , 'AccessController@index');
Route::post('/access/update/{id}' , 'AccessController@update');
Route::post('/access' , 'AccessController@store');
Route::delete('/access/{id}' , 'AccessController@destroy');

Route::get('/access/notify/{id}' , 'AccessController@notify');
