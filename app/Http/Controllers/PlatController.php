<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlatController extends Controller
{
   public function create_plat(){
        return view('BackOffice.create_plat');
   }
}
