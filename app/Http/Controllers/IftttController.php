<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
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
        $validator = Validator::make($request->all(), [
            'uuid'    => 'required',
            'if' => 'required',
            'opr' => 'required',
            'value' => 'required|numeric',
            'then' => 'required'
        ]);
        if ( ($request->input('uuid') == "0") | ($request->input('if') == "0") | ($request->input('opr') == "0") ){
            return redirect('/ifttt')
                ->withErrors('Please select all option.')
                ->withInput();
        }elseif ($validator->fails()) {
            return redirect('/ifttt')
                        ->withErrors($validator)
                        ->withInput(); // Request::old('field')
        }elseif ( $request->input('then') == "0" ){
            return redirect('/ifttt')
                ->withErrors('Please select then option.')
                ->withInput();
        }

        $input = $request->all();

        $created = Ifttt::create($input);

        return redirect('/ifttt')->with('status', 'IFTTT added.');
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
        return Ifttt::destroy($id);
    }
}
