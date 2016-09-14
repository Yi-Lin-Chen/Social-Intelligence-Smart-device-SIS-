<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'level', 'fb_id','is_deleted'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function fb_avatar($size = 1) {

        if( $this->fb_id == null || $this->fb_id == 'null' ) {

            $size = $size * 50;

            if( $size == 150 )
                $size += 50;

            return "http://placehold.it/$size" . "x" . "$size?text=?";
        }

        // 50, 100, 200
        $size_list = ['small', 'normal', 'large'];

        return 'https://graph.facebook.com/v2.6/' . $this->fb_id . '/picture?type=' . $size_list[$size - 1];
    }
}
