<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alamatip extends Model
{
  protected $table = 'alamatips';
  protected $fillable = ['id','alamat','status'];
}
