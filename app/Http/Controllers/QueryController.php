<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class QueryController extends Controller
{
    /*
     * API Format
     * /api/query?qr_code=[code]&checksum=[sum]
     *
     * Checksum Format
     * sha1('GoodWeb' + qr_code)
     */

    public function query(Request $request)
    {
        $qr_code = $request->input('qr_code');
        $checksum = $request->input('checksum');

        return [
            'qr_code'  => $qr_code,
            'checksum' => $checksum,
            'status' => true
        ];
    }
}
