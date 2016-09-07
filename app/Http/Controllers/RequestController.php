<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use Log;
use Hash;
use App\Http\Requests;

class RequestController extends Controller
{
    public function request()
    {
        return view('request');
    }

    public function redirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        if( $request->input('code') == null )
            abort(403);

        $obj = Socialite::driver('facebook')->user();

        Log::info('Got FB callback, User Name = ' . $obj->user['name'] . " ID = " . $obj->user['id']);

        // Check if user exist?
        $check = User::where('fb_id', $obj->user['id'])
                ->orWhere('email', $obj->user['email'])
                ->first();

        if( $check == null ) {

            Log::info('Got New User');

            // Save User to DB
            User::create([
                'name'  => $obj->user['name'],
                'email' => $obj->user['email'],
                'password' => Hash::make($obj->user['id']),
                'phone' => '',
                'level' => 0,
                'fb_id' => $obj->user['id']
            ]);

        } else {

            Log::info('Old User');
            Log::info($check);

        }

        return view('request-complete', [
            'name' => $obj->user['name']
        ]);
    }
}
