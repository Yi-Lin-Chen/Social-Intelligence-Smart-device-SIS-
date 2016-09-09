<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Http\Requests;
use App\User;
use Log;
use App\Access;

class EnterController extends Controller
{
    public function index()
    {
        return view('enter');
    }

    protected function changeCallback()
    {
        config(['services.facebook.redirect' => config('app.url') . '/enter/callback']);
        Log::info('Callback URL changed to: ' . config('services.facebook.redirect'));
    }

    public function redirect()
    {
        $this->changeCallback();
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        // 防止有人誤闖
        if( $request->input('code') == null )
            abort(403);

        $this->changeCallback();
        $obj = Socialite::driver('facebook')->user();

        Log::info('Got FB callback, User Name = ' . $obj->user['name'] . " ID = " . $obj->user['id']);

        $user = User::where('fb_id', $obj->user['id'])->orWhere('email', $obj->user['email'])->first();

        Log::info($user);

        $data = [
            'status' => false,
            'data'   => null
        ];

        if( $user != null ) {
            // User 存在
            $data['status'] = true;
            $data['data'] = Access::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        }

        return view('enter-complete', $data);
    }
}
