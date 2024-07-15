<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;

class PlatController extends Controller
{
    public function create_plat()
    {
        return view('BackOffice.create_plat');
    }

    public function store_plat(Request $req)
    {
        $req->validate([
            'titre' => 'required|string|max:255',
            'ingredients' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|in:entree,plat,dessert',
        ]);

        $imageName = time().'.'.$req->photo->extension();
        $req->photo->storeAs('public/images', $imageName);

        $plat = new Plat();
        $plat->titre = $req->titre;
        $plat->ingredients = $req->ingredients;
        $plat->photo = 'images/' . $imageName;
        $plat->type = $req->type;
        $plat->save();

        return redirect()->back()->with('success', 'Plat créé avec succès!');
    }

}
