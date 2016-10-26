<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Log;
use Mail;
use Storage;

class EmailController extends Controller
{
    public function notify_manager(Request $request) {

        Log::info($request->all());

        $ifttt = [
            'if' => $request->input('if'),
            'opr' => $request->input('opr'),
            'value' => $request->input('value'),
            'uuid' => $request->input('uuid')
        ];

        Log::info('/notify/manager');
        Log::info($ifttt);

        $path = null;
        if( $request->file('photo') != null ) {
            $path = $request->file('photo')->move('/tmp', uniqid() . '.jpg');
            Log::info($path);
        }

        return [
            'email' => $this->notifyManager((object)$ifttt, $path)
        ];
    }

    private function notifyManager($ifttt, $photo) {

        // Get All manager
        $manager_list = User::where('level', 1)->get();

        foreach( $manager_list as $manager ) {
            Log::debug('Send notify mail to ' . $manager->name . ' ' . $manager->email);
            Mail::to($manager)->send(new \App\Mail\NotifyIFTTT($manager, $ifttt, $photo));
        }

        return true;
    }
}
