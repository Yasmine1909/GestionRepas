<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function show(){
        return view('FrontOffice.welcome');
    }

    public function menu(){
        $entrees = Plat::where('type', 'entree')->get();
        $plats = Plat::where('type', 'plat')->get();
        $desserts = Plat::where('type', 'dessert')->get();

        return view('FrontOffice.menu', compact('entrees', 'plats', 'desserts'));
    }
}
