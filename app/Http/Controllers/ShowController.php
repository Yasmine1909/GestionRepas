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
            $currentDayOfWeek = $currentDate->dayOfWeek;

            $startOfCurrentWeek = $currentDate->copy()->startOfWeek(Carbon::MONDAY);

            if ($currentDayOfWeek == Carbon::FRIDAY) {
                $activeWeeksStart = $startOfCurrentWeek->copy()->addWeeks(2);
            } elseif ($currentDayOfWeek == Carbon::SATURDAY || $currentDayOfWeek == Carbon::SUNDAY) {
                $activeWeeksStart = $startOfCurrentWeek->copy()->addWeeks(2);
            } else {
                $activeWeeksStart = $startOfCurrentWeek->copy()->addWeek();
            }

            $weeks = Semaine::with('jours.plats')
                            ->orderBy('date_debut', 'desc')
                            ->paginate(6);

            return view('FrontOffice.menus', compact('weeks', 'currentDate', 'activeWeeksStart'));
        } else {

            return redirect()->route('admin.login');
        }
    }









public function modifier_menu($id)
{
    $plat = Plat::with(['jour.semaine'])->find($id);

    if (!$plat || !$plat->jour || !$plat->jour->semaine) {
        return redirect()->route('menus.index')->with('error', 'Le jour ou la semaine associée au plat est introuvable.');
    }

    $jour = $plat->jour;
    $semaine = $jour->semaine;

    $date = \Carbon\Carbon::parse($semaine->date_debut)->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']));

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

    return redirect()->route('menus')->with('success', 'Menu mis à jour avec succès!');
}

public function destroy($id)
{
    $plat = Plat::findOrFail($id);

    $jour = $plat->jour;

    if (!$jour) {
        return redirect()->back()->with('error', 'Jour associé au plat introuvable.');
    }

    $plat->delete();

    $semaine = $jour->semaine;

    if ($jour->plats()->count() === 0) {
        $jour->delete();

        if ($semaine && $semaine->jours()->count() === 0) {
            $semaine->delete();
        }
    }

    return redirect()->back()->with('success', 'Plat supprimé avec succès!');
}


public function dupliquerSemaine($id)
{
    $semaine = Semaine::with('jours.plats')->findOrFail($id);

    $nouvelleSemaine = $semaine->replicate();
    $nouvelleSemaine->date_debut = \Carbon\Carbon::parse($semaine->date_debut)->addWeek()->format('Y-m-d');
    $nouvelleSemaine->save();

    foreach ($semaine->jours as $jour) {
        $nouveauJour = $jour->replicate();
        $nouveauJour->semaine_id = $nouvelleSemaine->id;

        $nouvelleDateJour = \Carbon\Carbon::parse($nouvelleSemaine->date_debut)
            ->startOfWeek()
            ->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']));

        $nouveauJour->date = $nouvelleDateJour->format('Y-m-d');

        $nouveauJour->save();

        foreach ($jour->plats as $plat) {
            $nouveauPlat = $plat->replicate();
            $nouveauPlat->jour_id = $nouveauJour->id;
            $nouveauPlat->save();
        }
    }

    return redirect()->back()->with('success', 'Semaine dupliquée avec succès!');
}

public function supprimerSemaine($id)
{
    $semaine = Semaine::with('jours.plats')->findOrFail($id);

    foreach ($semaine->jours as $jour) {
        $jour->plats()->delete();
        $jour->delete();
    }

    $semaine->delete();

    return redirect()->back()->with('success', 'Semaine supprimée avec succès!');
}



public function notifications(){
        if (Auth::check()) {
        return view('FrontOffice.notifications');
    } else {
        return redirect()->route('login');
    }
    }
   public function statistiques()
{
    if (Auth::check()) {
        return view('admin.statistiques');
    } else {
        return redirect()->route('admin.login');
    }
}



}
