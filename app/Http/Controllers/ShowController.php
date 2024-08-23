<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use App\Models\Semaine;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['connexion', 'show']);
    }
    public function show(){
        if (Auth::check()) {
        return view('FrontOffice.welcome');
    } else {
        // Rediriger ou gérer les utilisateurs non connectés
        return redirect()->route('login');
    }
    }


    public function connexion(){
        return view('FrontOffice.connexion');
    }

    public function menus()
{
    if (Auth::check()) {
    $currentDate = Carbon::now();

    // Calculer le début et la fin de la semaine courante
    $startOfCurrentWeek = $currentDate->copy()->startOfWeek(Carbon::MONDAY);
    $endOfCurrentWeek = $startOfCurrentWeek->copy()->endOfWeek(Carbon::THURSDAY); // Jeudi de la semaine en cours

    // Début de la semaine suivante
    $startOfNextWeek = $startOfCurrentWeek->copy()->addWeek();

    // Calculer la date limite (jeudi de la semaine actuelle)
    $endOfCurrentWeekDate = $endOfCurrentWeek->format('Y-m-d');

    // Récupérer les semaines avec les jours et plats
    $weeks = Semaine::with('jours.plats')->orderBy('date_debut', 'desc')->get();

    return view('FrontOffice.menus', compact('weeks', 'currentDate', 'startOfCurrentWeek', 'endOfCurrentWeek', 'startOfNextWeek', 'endOfCurrentWeekDate'));

} else {
    // Rediriger ou gérer les utilisateurs non connectés
    return redirect()->route('login');
}
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

    if (!$jour) {
        return redirect()->back()->with('error', 'Jour associé au plat introuvable.');
    }

    // Supprimer le plat
    $plat->delete();

    // Trouver la semaine associée au jour
    $semaine = $jour->semaine;

    if ($jour->plats()->count() === 0) {
        // Supprimer le jour s'il est maintenant vide
        $jour->delete();

        if ($semaine && $semaine->jours()->count() === 0) {
            // Supprimer la semaine si elle est vide
            $semaine->delete();
        }
    }

    // Rediriger avec un message de succès
    return redirect()->back()->with('success', 'Plat supprimé avec succès!');
}


public function dupliquerSemaine($id)
{
    $semaine = Semaine::with('jours.plats')->findOrFail($id);

    // Créer une nouvelle semaine en se basant sur la semaine existante
    $nouvelleSemaine = $semaine->replicate();
    $nouvelleSemaine->date_debut = \Carbon\Carbon::parse($semaine->date_debut)->addWeek()->format('Y-m-d'); // Nouvelle date de début (semaine suivante)
    $nouvelleSemaine->save(); // Sauvegarder la nouvelle semaine

    // Dupliquer les jours et plats en les associant à la nouvelle semaine
    foreach ($semaine->jours as $jour) {
        $nouveauJour = $jour->replicate();
        $nouveauJour->semaine_id = $nouvelleSemaine->id; // Associer le jour à la nouvelle semaine

        // Calculer la nouvelle date du jour en fonction de la nouvelle semaine
        $nouvelleDateJour = \Carbon\Carbon::parse($nouvelleSemaine->date_debut)
            ->startOfWeek()
            ->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']));

        // Mettre à jour la date du jour
        $nouveauJour->date = $nouvelleDateJour->format('Y-m-d');

        $nouveauJour->save(); // Sauvegarder le nouveau jour

        foreach ($jour->plats as $plat) {
            $nouveauPlat = $plat->replicate();
            $nouveauPlat->jour_id = $nouveauJour->id; // Associer le plat au nouveau jour
            $nouveauPlat->save(); // Sauvegarder le nouveau plat
        }
    }

    // Rediriger vers la page précédente avec un message de succès
    return redirect()->back()->with('success', 'Semaine dupliquée avec succès!');
}

public function supprimerSemaine($id)
{
    $semaine = Semaine::with('jours.plats')->findOrFail($id);

    // Supprimer tous les plats et jours associés
    foreach ($semaine->jours as $jour) {
        $jour->plats()->delete();
        $jour->delete();
    }

    // Supprimer la semaine
    $semaine->delete();

    return redirect()->back()->with('success', 'Semaine supprimée avec succès!');
}




    public function notifications(){
        if (Auth::check()) {
        return view('FrontOffice.notifications');
    } else {
        // Rediriger ou gérer les utilisateurs non connectés
        return redirect()->route('login');
    }
    }
    public function statistiques(){
        if (Auth::check()) {
        return view('admin.statistiques');
    } else {
        // Rediriger ou gérer les utilisateurs non connectés
        return redirect()->route('login');
    }
    }

}
