<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Device;
use App\Ifttt;


class IftttController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'ifttt',[
            'devices' => Device::all(),
            'ifttts'   => Ifttt::all()
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

        // $validator = Validator::make($request->all(), [
        //     'user_id'    => 'required|integer',
        //     'expire_day' => 'required|integer'
        // ]);
        // if ($validator->fails()) {
        //     return redirect('/access')
        //                 ->withErrors($validator)
        //                 ->withInput(); // Request::old('field')
        // }elseif ($request->input('expire_day') < 0 ){
        //     return redirect('/access')
        //         ->withErrors('Expire day must be positive integer.');
        // }
        //
        //
        //
        // $input = $request->all();
        // $input['qr_code'] = sha1(uniqid());
        //
        // $created = Access::create($input);
        //
        // return redirect('/access')->with('status', 'Access granted.');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        return Ifttt::where( 'uuid', $uuid )->delete();
    }
}
