<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sidikjaris extends Model
{
  protected $table = 'sidikjaris';
  protected $fillable = ['id','nama','keterangan','pegawai_id','size', 'valid', 'templatefinger'];
}
