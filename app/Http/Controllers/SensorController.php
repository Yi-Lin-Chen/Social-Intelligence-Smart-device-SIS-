<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Access;
use Auth;

class SensorController extends Controller
{
    public function index()
    {
        return view('sensor', [
            'data'        => Access::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get(),
            'all_expired' => true
        ]);
    }
}
