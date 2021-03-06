<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Device;
use Auth;
use Log;
use Storage;

class DeviceController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware([
          'auth'
      ]);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
      return view('device');
  }

  public function all_device(){
      return [ 'device'=>Device::all(), 'manager'=>Auth::user()->isManager()];
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
      $dev = Device::where('uuid' , $request->input('uuid'));
      $ret = null;
      if( count($dev->get()) == 0 ){
        $ret = Device::create($request->all());
      }
      else{
        $ret = $dev->update([
            'x' => $request->input('x'),
            'y' => $request->input('y')
        ]);
      }
      return $ret;
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
  public function update( Request $request )
  {
      $path = null;
      if( $request->file('photo') != null ) {

          $path = Storage::put('public', $request->file('photo'));

          //Storage::move($path, 'storage')
          Log::debug($path);
          //$path = $this->fixUploadPath($path);
          Log::debug($path);

          Storage::delete('public/room_layout.jpg');
          $new_path = Storage::move($path, 'public/room_layout.jpg');
          Log::debug($new_path);

          return redirect('/device')->with('status', 'Upload success.');
      }
      else{
          return redirect('/device')->with('status', 'Upload fail.');
      }
  }

  protected function fixUploadPath($path) {
      return str_replace('public/', 'pubilc/', $path);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy( $uuid )
  {
      return Device::where( 'uuid', $uuid )->delete();
  }
}
