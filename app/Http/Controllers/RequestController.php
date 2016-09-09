<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use Log;
use Hash;
use Mail;

use App\User;
use App\RequestModel;

class RequestController extends Controller
{
    public function request()
    {
        return view('request');
    }

    public function redirect()
    {
        config(['services.facebook.redirect' => config('app.url') . '/request/callback']);
        Log::info('Callback URL changed to: ' . config('services.facebook.redirect'));
        return Socialite::driver('facebook')->redirect();
    }

    public function callback(Request $request)
    {
        // 防止有人誤闖
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
            $check = User::create([
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

            // Insert fb_id if null
            if( $check->fb_id == null ) {
                $check->fb_id = $obj->user['id'];
                $check->save();
            }

        }

        // 存入 Request 紀錄
        $req = RequestModel::create([
            'user_id' => $check->id,
            'state'   => 'pending'
        ]);

        // 通知管理員有人要求權限
        $this->notifyManager($check, $req->id);

        return view('request-complete', [
            'name' => $obj->user['name']
        ]);
    }

    private function notifyManager(User $user, $req_id) {

        // Get All manager
        $manager_list = User::where('level', 1)->get();

        foreach( $manager_list as $manager ) {
            Log::debug('Send notify mail to ' . $manager->name);
            Mail::to($manager)->send(new \App\Mail\RequestForAccess($user, $req_id));
        }

    }
}
