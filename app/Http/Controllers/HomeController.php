<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Record;
use Log;

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

    public function door($query, Request $request)
    {
        $query_map = [
            'unlock' => 'lock/'  . $query,
            'lock'   => 'lock/'  . $query,
            'status' => 'lock/'  . $query,
            'photo'  => 'photo/' . $query,
            'record' => 'photo/' . $query . '?ts=' . $request->input('ts')
        ];

        Log::debug('Door query: '. $query . ' map to: ' . $query_map[$query]);

        if( env('DOOR_SERVER_DRY_RUN') == false )  {

            $client = new \GuzzleHttp\Client();
            try {
                $res = $client->request('GET', env('DOOR_SERVER_URL') . $query_map[$query]);
            } catch (Exception $e) {
                return ['status' => $e->getMessage()];
            }
            if( $res->getStatusCode() != 200 ) {
                return ['status' => $res->getStatusCode()];
            }
            if( $query == 'photo') {
                return Response::make($res->getBody(), 200, ['Content-Type' => 'image/jpeg']);
            }
            else {
                return $res->getBody();
            }
        }
        else {
            Log::debug('Door server api dry run mode');
            //abort(500);
        }
    }
}
