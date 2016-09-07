<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use App\Http\Requests;

class ApprovalController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function list() {
        return view('approval', [
            'type'    => 'list',
            'request' => RequestModel::all()
        ]);
    }

    public function grant($id) {

        // Change Request State
        RequestModel::where('id', $id)->update(['state' => 'allow']);

        // Create a Request record for the user
        return redirect('/approval');
    }

    public function deny($id) {

        RequestModel::where('id', $id)->update(['state' => 'deny']);
        
        return redirect('/approval');
    }

    public function show($id) {

        $req = RequestModel::find($id);

        if( $req == null )
            abort(404);

        return view('approval', [
            'type'    => 'single',
            'request' => $req,
            'user'    => $req->user()->first()
        ]);
    }
}
