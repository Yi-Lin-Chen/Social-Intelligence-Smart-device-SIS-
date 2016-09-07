<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Access;
use App\User;
use App\Http\Requests;
use Validator;

class AccessController extends Controller
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
            'user'       => 'required|integer',
            'expire_day' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return redirect('/access')
                        ->withErrors($validator)
                        ->withInput(); // Request::old('field')
        }

        $input = $request->all();
        $qrcode = sha1(uniqid());
        $access_data = [$qrcode,$input['user'],$input['expire_day']];
        $created = Access::create($access_data);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
