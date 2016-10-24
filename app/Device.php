<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
  protected $table = 'device';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'uuid', 'posx', 'posy'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [

  ];
}
