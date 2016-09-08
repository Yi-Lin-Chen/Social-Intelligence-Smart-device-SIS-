<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function door($query)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->request('GET', env('DOOR_SERVER_URL') . $query);
        } catch (Exception $e) {
            return ['status' => $e->getMessage()];
        }

        if( $res->getStatusCode() != 200 ) {
            return ['status' => $res->getStatusCode()];
        }

        if( $query == 'photo') {
            return Response::make($res->getBody(), 200, ['Content-Type' => 'image/jpeg']);
            //return response($res->getBody())->header('Content-Type', 'text/jpeg');
        }
        else
            return $res->getBody();
    }
}
