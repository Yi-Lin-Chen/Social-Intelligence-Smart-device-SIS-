<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Socialite;
use Log;
use Hash;
use Mail;
use Auth;

use App\User;
use App\RequestModel;

class RequestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth'
        ]);
    }

    public function request()
    {
        return view('request');
    }

    public function send(Request $request)
    {

        $check = Auth::user();

        // 存入 Request 紀錄
        $req = RequestModel::create([
            'user_id' => $check->id,
            'state'   => 'pending'
        ]);

        // 通知管理員有人要求權限
        $this->notifyManager($check, $req->id);

        return view('request-complete', [
            'name' => $check->name
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
