<?php

namespace App\Http\Controllers;

use App\Models\Semaine;
use App\Models\Jour;
use App\Models\Plat;
use App\Models\ActiveDaysConfiguration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function ajouter_menu()
    {
        if (Auth::check()) {
            $currentFriday = Carbon::now()->startOfWeek()->addDays(4)->format('Y-m-d');
            $currentDate = Carbon::now()->format('Y-m-d');
            $disabledDays = [];
            $selectedWeek = request()->input('week_start');

            if ($selectedWeek) {
                try {
                    $weekStartDate = Carbon::parse($selectedWeek . '-1');
                    $weekStartFormatted = $weekStartDate->startOfWeek()->format('Y-m-d');
                    $week = Semaine::where('date_debut', $weekStartFormatted)->first();

                    if ($week) {
                        $jours = Jour::where('semaine_id', $week->id)->pluck('jour')->toArray();
                        $daysMap = [
                            'lundi' => 'Lundi',
                            'mardi' => 'Mardi',
                            'mercredi' => 'Mercredi',
                            'jeudi' => 'Jeudi',
                            'vendredi' => 'Vendredi'
                        ];
                        $disabledDays = array_map(function($day) use ($daysMap) {
                            return $daysMap[$day];
                        }, $jours);
                    }
                } catch (\Exception $e) {
                    return redirect()->back()->withErrors(['week_start' => 'La date de début de semaine n\'est pas valide.'])->withInput();
                }
            }

            return view('FrontOffice.ajouter_menu', compact('currentFriday', 'currentDate', 'disabledDays'));
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function store(Request $request)
{
    $request->validate([
        'week_start' => ['required', 'regex:/^\d{4}-W\d{2}$/'],
        'active_days.*' => 'in:Lundi,Mardi,Mercredi,Jeudi,Vendredi',
        'plat_title_Lundi' => 'nullable|string',
        'plat_title_Mardi' => 'nullable|string',
        'plat_title_Mercredi' => 'nullable|string',
        'plat_title_Jeudi' => 'nullable|string',
        'plat_title_Vendredi' => 'nullable|string',
    ]);

    $weekStart = $request->input('week_start');
    $activeDays = $request->input('active_days', []);
    $plats = $request->except(['week_start', 'active_days', '_token']);

    try {
        $weekStartDate = Carbon::parse($weekStart . '-1');
        $weekStartFormatted = $weekStartDate->startOfWeek()->format('Y-m-d');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['week_start' => 'La date de début de semaine n\'est pas valide.'])->withInput();
    }

    // Vérification des semaines existantes
    $existingWeek = Semaine::where('date_debut', $weekStartFormatted)->first();
    if ($existingWeek) {
        return redirect()->back()->with('error', 'Cette semaine est déjà configurée')->withInput();
    }

    // Vérification des dates limites
    $currentFriday = Carbon::now()->startOfWeek()->addDays(4)->format('Y-m-d');
    $currentMonday = Carbon::now()->startOfWeek()->format('Y-m-d');

    // Permettre la configuration pour les jours futurs à partir de lundi
    if ($weekStartFormatted <= $currentFriday || $weekStartFormatted < $currentMonday) {
        return redirect()->back()->with('error', 'La semaine sélectionnée doit être après le vendredi de la semaine en cours.')->withInput();
    }

    // Création de la semaine
    $semaine = Semaine::create(['date_debut' => $weekStartFormatted]);

    // Création des jours et plats
    $jours = [
        'Lundi' => 'lundi',
        'Mardi' => 'mardi',
        'Mercredi' => 'mercredi',
        'Jeudi' => 'jeudi',
        'Vendredi' => 'vendredi'
    ];

    foreach ($jours as $day => $jourKey) {
        if (in_array($day, $activeDays)) {
            $jour = Jour::create([
                'semaine_id' => $semaine->id,
                'jour' => $jourKey,
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

    Log::info('Week Start Formatted: ' . $weekStartFormatted);
    Log::info('Current Friday: ' . $currentFriday);
    Log::info('Current Monday: ' . $currentMonday);

    return redirect()->route('ajouter_menu')->with('success', 'Menus enregistrés avec succès !');
}









    // Méthode pour afficher le formulaire de configuration hebdomadaire
    public function showWeeklyMenuForm()
{
    $configuration = ActiveDaysConfiguration::first();
    $activeDays = $configuration ? $configuration->active_days : [];

    $daysMapping = [
        'Lundi' => Carbon::MONDAY,
        'Mardi' => Carbon::TUESDAY,
        'Mercredi' => Carbon::WEDNESDAY,
        'Jeudi' => Carbon::THURSDAY,
        'Vendredi' => Carbon::FRIDAY,
    ];

    $today = Carbon::today();

    if (in_array($today->dayOfWeek, [Carbon::FRIDAY, Carbon::SATURDAY, Carbon::SUNDAY])) {
        $nextMonday = $today->copy()->addWeeks(2)->startOfWeek(Carbon::MONDAY);
    } else {
        $nextMonday = $today->copy()->addWeeks(1)->startOfWeek(Carbon::MONDAY);
    }

    $dates = [];

    foreach ($activeDays as $day) {
        if (isset($daysMapping[$day])) {
            $date = $nextMonday->copy()->addDays($daysMapping[$day] - Carbon::MONDAY)->startOfDay();
            $dates[$day] = $date;
        }
    }

    return view('admin.ajouter_menu', compact('dates'));
}


    // Méthode pour enregistrer le menu hebdomadaire
    public function storeWeeklyMenu(Request $request)
    {
        $menus = $request->input('menus');

        $today = Carbon::today();
        $startOfNextWeek = $today->copy()->addWeeks(1)->startOfWeek();

        $semaine = Semaine::where('date_debut', $startOfNextWeek->format('Y-m-d'))->first();

        if ($semaine) {
            return redirect()->route('admin.show_weekly_menu_form')->with('error', 'Semaine déjà configurée !');
        }

        $semaine = Semaine::create(['date_debut' => $startOfNextWeek->format('Y-m-d')]);

        foreach ($menus as $date => $pack) {
            $date = Carbon::parse($date);

            $dayInFrench = $date->translatedFormat('l');
            $dayMapping = [
                'Monday' => 'lundi',
                'Tuesday' => 'mardi',
                'Wednesday' => 'mercredi',
                'Thursday' => 'jeudi',
                'Friday' => 'vendredi',
            ];

            $dayEnum = isset($dayMapping[$dayInFrench]) ? $dayMapping[$dayInFrench] : $dayInFrench;

            $jour = Jour::where('semaine_id', $semaine->id)
                        ->whereDate('date', $date->format('Y-m-d'))
                        ->first();

            if (!$jour) {
                $jour = Jour::create([
                    'semaine_id' => $semaine->id,
                    'date' => $date->format('Y-m-d'),
                    'jour' => $dayEnum
                ]);
            }

            Plat::updateOrCreate(
                ['jour_id' => $jour->id],
                ['titre' => $pack]
            );
        }

        return redirect()->route('admin.show_weekly_menu_form')->with('success', 'Menus enregistrés avec succès !');
    }

    // Méthode pour télécharger le PDF du menu
    public function downloadPDF(Request $request, $weekId)
    {
        $week = Semaine::with('jours.plats')->findOrFail($weekId);
        $week->date_debut = Carbon::parse($week->date_debut);
        $pdf = Pdf::loadView('pdf.menu', ['week' => $week]);
        return $pdf->download('menu_semaine_' . $week->date_debut->format('Y_m_d') . '.pdf');
    }
}
