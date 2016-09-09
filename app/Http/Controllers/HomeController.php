<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Record;

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
        return view('home', [
            'records' => Record::orderBy('created_at', 'desc')->limit(10)->get()
        ]);
    }

    public function door($query)
    {
        if( env('DOOR_SERVER_DRY_RUN') == false )  {

            $client = new \GuzzleHttp\Client();

            $request = new \GuzzleHttp\Psr7\Request('GET', env('DOOR_SERVER_URL') . $query);

            $promise = $client->sendAsync($request)->then(function ($response) {

                if( $res->getStatusCode() != 200 ) {
                    return ['status' => $res->getStatusCode()];
                }

                if( $query == 'photo') {
                    return Response::make($res->getBody(), 200, ['Content-Type' => 'image/jpeg']);
                }
                else {
                    return $res->getBody();
                }
            });

            $promise->wait();

        } else {

            abort(500);

        }
    }
}
