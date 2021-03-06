<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\User;
use App\Http\Requests;
use Validator;
use Mail;
use Log;

class AccessController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'auth',
            'auth.admin'
        ]);
    }

    public function notify($id) {

        $access = Access::find($id);

        if( $access == null )
            abort(404);

        return Mail::to($access->user()->first())->send(new \App\Mail\NotifyUserWithQRCode($access));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('access', [
            'access_array' => Access::all(),
            'user_array'   => User::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|integer',
            'expire_day' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return redirect('/access')
                        ->withErrors($validator)
                        ->withInput(); // Request::old('field')
        }elseif ($request->input('expire_day') < 0 ){
            return redirect('/access')
                ->withErrors('Expire day must be positive integer.')
                ->withInput();
        }



        $input = $request->all();
        $input['qr_code'] = sha1(uniqid());

        $created = Access::create($input);

        return redirect('/access')->with('status', 'Access granted.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'expire_day' => 'integer',
            'qr_code'    => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect('/access')
                ->withErrors($validator)
                ->withInput(); // Request::old('field')
        }elseif ($request->input('expire_day') < 0 ){
            return redirect('/access')
                ->withErrors('Expire day must be positive integer.');
        }

        $input = $request->all();
        unset($input['_token']);
        if ( $input['expire_day'] == null ){
            unset($input['expire_day']);
        }
        if ( $input['qr_code'] == '1') {
            $input['qr_code'] = sha1(uniqid());
        }else{
            unset($input['qr_code']);
        }

        Access::where('id' , '=' , $id)->update($input);
        return redirect('/access')->with('status', 'Access updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Access::destroy($id);
    }
}
