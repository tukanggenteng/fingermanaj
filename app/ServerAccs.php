<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerAccs extends Model
{
  protected $table = 'serveraccs';
  protected $fillable = ['id','url_server','status'];
}
