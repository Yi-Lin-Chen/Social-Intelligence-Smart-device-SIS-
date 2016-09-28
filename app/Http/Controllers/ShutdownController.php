<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\User;
use Hash;

class ShutdownController extends Controller
{
    public function do_shutdown(Request $request) {

        $status = false;
        $pass = $request->input('password');
        $user = User::where('email', Auth::user()->email)->first();

        if( Hash::check($pass, $user->password) ) {
            // Pass
            $status = true;
            exec(env('SHUTDOWN_CMD', 'sudo shutdown'));
        }

        return [
            'status' => $status
        ];
    }
}
