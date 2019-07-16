<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sidikjaris extends Model
{
  protected $table = 'sidikjaris';
  protected $fillable = ['id','url_server','pegawai_id','size', 'valid', 'templatefinger'];
}
