<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SensorController extends Controller
{
    public function index()
    {
        return view('sensor');
    }
}
