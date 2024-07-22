<?php

namespace App\Http\Controllers;

use App\Models\Semaine;
use App\Models\Jour;
use App\Models\Plat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function ajouter_menu()
    {
        // Calculer le vendredi de la semaine en cours
        $currentFriday = Carbon::now()->startOfWeek()->addDays(4)->format('Y-m-d');
        // Calculer la date actuelle
        $currentDate = Carbon::now()->format('Y-m-d');

        return view('FrontOffice.ajouter_menu', compact('currentFriday', 'currentDate'));
    }

    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'week_start' => ['required', 'regex:/^\d{4}-W\d{2}$/'],
            'active_days.*' => 'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi',
            'plat_title_Lundi' => 'nullable|string',
            'plat_title_Mardi' => 'nullable|string',
            'plat_title_Mercredi' => 'nullable|string',
            'plat_title_Jeudi' => 'nullable|string',
            'plat_title_Vendredi' => 'nullable|string',
        ]);

        // Récupération des données
        $weekStart = $request->input('week_start');
        $activeDays = $request->input('active_days', []);
        $plats = $request->except(['week_start', 'active_days', '_token']);

        // Vérification et conversion du format de la semaine
        try {
            $weekStartDate = Carbon::parse($weekStart . '-1');
            $weekStartFormatted = $weekStartDate->startOfWeek()->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['week_start' => 'La date de début de semaine n\'est pas valide.'])->withInput();
        }

        // Calculer le vendredi de la semaine en cours
        $currentFriday = Carbon::now()->startOfWeek()->addDays(4)->format('Y-m-d');
        // Calculer le lundi de la semaine en cours
        $currentMonday = Carbon::now()->startOfWeek()->format('Y-m-d');

        // Vérifier si la semaine existe déjà
        if (Semaine::where('date_debut', $weekStartFormatted)->exists()) {
            return redirect()->back()->with('error', 'Cette Semaine est déjà configurée')->withInput();
        }

        // Vérifier si la semaine sélectionnée est antérieure ou égale au vendredi de la semaine en cours
        if ($weekStartFormatted <= $currentFriday || $weekStartFormatted == $currentMonday) {
            return redirect()->back()->with('error', 'La semaine sélectionnée doit être après le vendredi de la semaine en cours.')->withInput();
        }

        // Enregistrer la semaine avec le format correct
        $semaine = Semaine::create(['date_debut' => $weekStartFormatted]);

        // Liste des jours de la semaine en français
        $jours = [
            'Lundi' => 'lundi',
            'Mardi' => 'mardi',
            'Mercredi' => 'mercredi',
            'Jeudi' => 'jeudi',
            'Vendredi' => 'vendredi'
        ];

        // Enregistrer les jours et plats
        foreach ($jours as $day => $jourKey) {
            if (in_array($day, $activeDays)) {
                $jour = Jour::create([
                    'semaine_id' => $semaine->id,
                    'jour' => $jourKey, // Le nom du jour en minuscule
                ]);

                $platKey = "plat_title_$day";
                if (isset($plats[$platKey])) {
                    Plat::create([
                        'jour_id' => $jour->id,
                        'titre' => $plats[$platKey],
                    ]);
                }
            }
        }

        return redirect()->route('ajouter_menu')->with('success', 'Menus enregistrés avec succès !');
    }
}
