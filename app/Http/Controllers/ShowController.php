<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Semaine;
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
    public function connexion(){
        return view('FrontOffice.connexion');
    }

    public function menus(){
        $currentDate = \Carbon\Carbon::now();
        $weeks = Semaine::with('jours.plats')->orderBy('date_debut', 'desc')->get();

        return view('FrontOffice.menus', compact('weeks','currentDate'));

    }
    public function modifier_menu($id)
    {
        // Trouver le plat par ID
        $plat = Plat::with(['jour.semaine'])->find($id);

        // Vérifier que le plat existe et qu'il a une relation jour
        if (!$plat || !$plat->jour || !$plat->jour->semaine) {
            return redirect()->route('menus.index')->with('error', 'Le jour ou la semaine associée au plat est introuvable.');
        }

        // Récupérer le jour et la semaine associés au plat
        $jour = $plat->jour;
        $semaine = $jour->semaine;

        // Calculer la date du jour
        $date = \Carbon\Carbon::parse($semaine->date_debut)->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']));

        // Passer les données à la vue
        return view('FrontOffice.modifier_menu', compact('plat', 'jour', 'semaine', 'date'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        $plat = Plat::findOrFail($id);

        $plat->titre = $request->input('titre');

        $plat->save();

        // Redirection après mise à jour
        return redirect()->back()->with('success', 'Menu mis à jour avec succès!');
    }


    public function destroy($id)
{
    // Trouver le plat par ID
    $plat = Plat::findOrFail($id);

    // Trouver le jour associé au plat
    $jour = $plat->jour;

    // Supprimer le plat
    $plat->delete();

    // Vérifier si le jour est maintenant vide
    if ($jour->plats()->count() === 0) {
        // Supprimer le jour
        $jour->delete();

        // Vérifier si la semaine est maintenant vide
        $semaine = $jour->semaine;
        if ($semaine->jours()->count() === 0) {
            // Supprimer la semaine si elle est vide
            $semaine->delete();
        }
    }

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Plat supprimé avec succès!');
}





    public function notifications(){
        return view('FrontOffice.notifications');
    }
    public function dashboard(){
        return view('FrontOffice.dashboard');
    }
}
