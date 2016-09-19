<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Access;
use Auth;
use Log;

class DashboardController extends Controller
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

    public function index()
    {
        return view('dashboard', [
            'data'   => Access::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
        ]);
    }
}
