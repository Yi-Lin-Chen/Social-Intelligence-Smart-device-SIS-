<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Access;
use Log;

class QueryController extends Controller
{
    /*
     * API Format
     * /api/query?qr_code=[code]&checksum=[sum]
     *
     * Checksum Format
     * sha1('GoodWeb' + qr_code)
     * Test: http://localhost:8000/api/query?qr_code=e472b7e8d315004ec7a14268f18f95d8a9728173&checksum=adc293a667163a1b5008cf26bbe76a8e3f4fa233
     */

    private function checkSum($qr_code, $checksum) {
        return sha1('GoodWeb' . $qr_code) == $checksum;
    }

    public function query(Request $request)
    {
        $qr_code = $request->input('qr_code');
        $checksum = $request->input('checksum');
        $status = true;
        $error_code = 200;

        if( !$this->checkSum($qr_code, $checksum) ) {
            // Checksum 錯了叭叭
            $status = false;
            $error_code = 401;
        } else {

            $query = Access::where('qr_code', $qr_code)->first();
            Log::debug($query);

            if( $query == null ) {
                // 沒找到
                $status = false;
                $error_code = 404;
            } else {
                // QR Code 真的存在
                // 驗證是否過期
                if( $query->isExpired() ) {
                    // 過期了
                    $status = false;
                    $error_code = 403;
                }
            }
        }

        return [
            'qr_code'  => $qr_code,
            'checksum' => $checksum,
            'status' => $status,
            'error'  => $error_code
        ];
    }
}
