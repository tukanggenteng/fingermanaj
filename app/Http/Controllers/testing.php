<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testing extends Controller
{
    public function tesFungsi()
    {
      $atts[0]->hari ='00:00:11';
      $atts[0]->tanggal_att= date('d-m-Y', strtotime($atts[0]->hari));
      if($atts[0]->apel=='0')
        { $atts[0]->apel = 'TIDAK APEL';  }
      else
        { $atts[0]->apel = 'APEL';  }

      dd($atts[0]->apel);
    }
}
