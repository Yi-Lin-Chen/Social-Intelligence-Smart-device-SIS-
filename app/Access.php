<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{

    protected $table = 'access';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'qr_code', 'expire_day', 'user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function qr_code() {
        return 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&choe=UTF-8&chl=' . $this->qr_code;
    }

    public function getActualExpireTime() {

        if( $this->expire_day == 0 ) {
            // Will not expire
            return null;
        }

        $date = new \DateTime($this->created_at, new \DateTimeZone(config('app.timezone')));
        $date->modify( '+' . ($this->expire_day * 24). ' hour');
        return $date->format('Y-m-d H:i:s');
    }

    public function isExpired() {

        if( $this->expire_day == 0 ) {
            // Will not expire
            return false;
        }

        $expire_date  = new \DateTime($this->getActualExpireTime(), new \DateTimeZone(config('app.timezone')));
        $current_date = new \DateTime('NOW', new \DateTimeZone(config('app.timezone')));
        return $expire_date < $current_date;
    }
}
