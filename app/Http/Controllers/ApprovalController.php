<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RequestModel;
use App\Http\Requests;
use App\Access;
use Mail;

class ApprovalController extends Controller
{
    public function __construct() {
        $this->middleware([
            'auth',
            'auth.admin'
        ]);
    }

    public function list() {
        return view('approval', [
            'type'    => 'list',
            'request' => RequestModel::all()
        ]);
    }

    public function grant($id) {

        // Change Request State
        $m   = RequestModel::where('id', $id);
        $req = $m->update(['state' => 'allow']);
        $acc = null;

        if( $req ) {

            // Update success
            $req = $m->first();

            $acc = Access::create([
                'qr_code'    => sha1(uniqid()),
                'expire_day' => 1,
                'user_id'    => $req->user_id
            ]);

            Mail::to($acc->user()->first())->send(new \App\Mail\NotifyUserWithQRCode($acc));
        }

        // Create a Request record for the user
        return redirect('/approval')->with('status', '24hr Access #' . $acc->id . ' created for User #' . $req->user_id);
    }

    public function deny($id) {

        $m   = RequestModel::where('id', $id);
        $req = $m->update(['state' => 'deny']);
        $r   = $m->first();

        Mail::to($r->user()->first())->send(new \App\Mail\NotifyUserDeny($r->user()->first()));

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

    public function destroy($id){
        return RequestModel::destroy($id);
    }

}
