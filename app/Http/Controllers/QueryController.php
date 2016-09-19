<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Access;
use App\Record;
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

    private function checkSum($qr_code, $checksum)
    {
        return sha1('GoodWeb' . $qr_code) == $checksum;
    }

    private function record($photo_ts, $ip, $error_code, $note, $access_id = null)
    {
        Record::create([
            'ip'         => $ip,
            'error_code' => $error_code,
            'note'       => $note,
            'access_id'  => $access_id,
            'photo_ts'   => $photo_ts
        ]);
    }

    public function query(Request $request)
    {
        $qr_code    = $request->input('qr_code');
        $checksum   = $request->input('checksum');
        $photo_ts   = $request->input('photo_ts');
        $status     = true;
        $error_code = 200;

        if( !$this->checkSum($qr_code, $checksum) ) {

            // Checksum 錯了叭叭
            $status = false;
            $error_code = 400;

            // 紀錄 IP, note = qr_code, access_id = null
            $this->record($photo_ts, $request->ip(), $error_code, $qr_code);

        } else {

            $query = Access::where('qr_code', $qr_code)->first();
            Log::debug($query);

            if( $query == null ) {

                // 沒找到
                $status = false;
                $error_code = 404;

                // 紀錄 IP, note = qr_code, access_id = null
                $this->record($photo_ts, $request->ip(), $error_code, $qr_code);

            } else {

                // QR Code 真的存在
                // 驗證是否過期
                if( $query->isExpired() ) {

                    // 過期了
                    $status = false;
                    $error_code = 403;

                    // 紀錄 IP, note = qr_code, access_id = null, access id
                    $this->record($photo_ts, $request->ip(), $error_code, $qr_code, $query->id);

                } else {

                    // Success
                    $this->record($request->ip(), $error_code, $qr_code, $query->id);

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
