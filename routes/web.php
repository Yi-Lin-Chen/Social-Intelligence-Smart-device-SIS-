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

Route::get('/', function () { return view('welcome');});

Auth::routes();

// Device Control Route
Route::get('/device', 'DeviceController@index');
Route::post('/device' , 'DeviceController@store');
Route::get('/device/all', 'DeviceController@all_device');
Route::post('/device/upload', 'DeviceController@update');
Route::delete('/device/{uuid}' , 'DeviceController@destroy');
Route::get('/sensor/{uuid}', 'SensorController@index');
Route::get('/bb8-control', function(){ return view('bb8-control'); });
Route::get('/ifttt', 'IftttController@index');
Route::post('/ifttt', 'IftttController@store');
Route::delete('/ifttt/{uuid}', 'IftttController@destroy');

// Facebook Login Route
Route::get('/auth/facebook/redirect', 'Auth\LoginController@redirectToFacebook');
Route::get('/auth/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// Dashboard, display QR
Route::get('/dashboard', 'DashboardController@index');

// Facebook Login Route
Route::get('/request', 'RequestController@request');
Route::get('/request/send', 'RequestController@send');

// Manager Approval
Route::get('/approval', 'ApprovalController@list');
Route::get('/approval/{id}', 'ApprovalController@show');
Route::get('/approval/grant/{id}', 'ApprovalController@grant');
Route::get('/approval/deny/{id}', 'ApprovalController@deny');
Route::delete('/approval/{id}' , 'ApprovalController@destroy');

// Direct Control
Route::get('/home' , 'HomeController@index');
Route::get('/home/door/{query}' , 'HomeController@door');
Route::post('/home/shutdown', 'ShutdownController@do_shutdown');

// Manage User
Route::get('/user' , 'UserController@index');
Route::post('/user/update/{id}' , 'UserController@update');
Route::post('/user' , 'UserController@store');
Route::delete('/user/{id}' , 'UserController@destroy');

// Manage Access
Route::get('/access' , 'AccessController@index');
Route::post('/access/update/{id}' , 'AccessController@update');
Route::post('/access' , 'AccessController@store');
Route::delete('/access/{id}' , 'AccessController@destroy');
Route::get('/access/notify/{id}' , 'AccessController@notify');
