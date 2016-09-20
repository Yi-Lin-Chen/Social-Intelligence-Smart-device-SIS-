<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Log;
use App\User;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback()
    {
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
                'password' => Hash::make($obj->user['id'] . uniqid()),
                'phone' => '',
                'level' => 0,
                'fb_id' => $obj->user['id']
            ]);

        } else {

            Log::info('Old User');
            Log::info($check);

            // Insert fb_id if null
            if( $check->fb_id == null || $check->fb_id == 'null') {
                $check->fb_id = $obj->user['id'];
                $check->save();
            }

            if( $check->is_deleted == true){
                $check->is_deleted = false;
                $check->save();
            }

        }

        Auth::login($check);
        return redirect($this->redirectTo);
    }
}
