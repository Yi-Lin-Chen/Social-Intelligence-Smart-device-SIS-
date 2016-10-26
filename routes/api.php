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

// 預設都有 /api 在前面
Route::get('/query', 'QueryController@query');

// Email notification
Route::post('/notify/manager', 'EmailController@notify_manager');
