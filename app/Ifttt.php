<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ifttt extends Model
{
    protected $table = 'ifttt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'if', 'opr', 'value', 'then'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
