<?php

namespace App\Http\Controllers;

use App\Models\Semaine;
use App\Models\Jour;
use App\Models\Plat;
use App\Models\ActiveDaysConfiguration;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Assurez-vous d'avoir installé le package barryvdh/laravel-dompdf


class MenuController extends Controller
{
    public function ajouter_menu()
    {
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

        $currentFriday = Carbon::now()->startOfWeek()->addDays(4)->format('Y-m-d');
        $currentMonday = Carbon::now()->startOfWeek()->format('Y-m-d');

        if (Semaine::where('date_debut', $weekStartFormatted)->exists()) {
            return redirect()->back()->with('error', 'Cette Semaine est déjà configurée')->withInput();
        }

        if ($weekStartFormatted <= $currentFriday || $weekStartFormatted == $currentMonday) {
            return redirect()->back()->with('error', 'La semaine sélectionnée doit être après le vendredi de la semaine en cours.')->withInput();
        }

        $semaine = Semaine::create(['date_debut' => $weekStartFormatted]);

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

        return redirect()->route('ajouter_menu')->with('success', 'Menus enregistrés avec succès !');
    }



    //  public function modifierSemaine($id)
    // {
    //     $week = Semaine::with('jours.plats')->findOrFail($id);

    //     $activeDays = $week->jours->pluck('jour')->toArray();
    //     $activeDays = array_map('ucfirst', $activeDays);

    //     return view('BackOffice.modifier_semaine', compact('week', 'activeDays'));
    // }

    // public function updateWeek(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'active_days' => 'required|array|min:1',
    //         'plat_title_lundi' => 'nullable|string|max:255',
    //         'plat_title_mardi' => 'nullable|string|max:255',
    //         'plat_title_mercredi' => 'nullable|string|max:255',
    //         'plat_title_jeudi' => 'nullable|string|max:255',
    //         'plat_title_vendredi' => 'nullable|string|max:255',
    //     ]);

    //     $week = Semaine::findOrFail($id);

    //     DB::transaction(function() use ($week, $validatedData) {
    //         // Récupération des jours déjà existants
    //         $existingJours = $week->jours->keyBy('jour')->toArray();

    //         $daysMap = [
    //             'lundi' => 'lundi',
    //             'mardi' => 'mardi',
    //             'mercredi' => 'mercredi',
    //             'jeudi' => 'jeudi',
    //             'vendredi' => 'vendredi'
    //         ];

    //         foreach ($validatedData['active_days'] as $day) {
    //             $dayKey = strtolower($day);

    //             if (!isset($existingJours[$dayKey])) {
    //                 $jour = new Jour();
    //                 $jour->semaine_id = $week->id;
    //                 $jour->jour = $dayKey;
    //                 $jour->save();
    //             } else {
    //                 $jour = $week->jours->firstWhere('jour', $dayKey);
    //             }

    //             $platTitleKey = 'plat_title_' . $dayKey;
    //             if (isset($validatedData[$platTitleKey])) {
    //                 Plat::updateOrCreate(
    //                     ['jour_id' => $jour->id],
    //                     ['titre' => $validatedData[$platTitleKey]]
    //                 );
    //             }
    //         }

    //         // Supprimer les jours non sélectionnés
    //         foreach ($existingJours as $dayKey => $jour) {
    //             if (!in_array($dayKey, array_map('strtolower', $validatedData['active_days']))) {
    //                 $jourModel = Jour::where('semaine_id', $week->id)->where('jour', $dayKey)->first();
    //                 if ($jourModel) {
    //                     $jourModel->plats()->delete();
    //                     $jourModel->delete();
    //                 }
    //             }
    //         }
    //     });

    //     return redirect()->route('modifier_semaine', $week->id)->with('success', 'La semaine a été modifiée avec succès.');
    // }
    public function showWeeklyMenuForm()
    {
        $configuration = ActiveDaysConfiguration::first();
        $activeDays = $configuration ? $configuration->active_days : [];

        // Mapping des jours en français vers les constantes de jour de Carbon
        $daysMapping = [
            'Lundi' => Carbon::MONDAY,
            'Mardi' => Carbon::TUESDAY,
            'Mercredi' => Carbon::WEDNESDAY,
            'Jeudi' => Carbon::THURSDAY,
            'Vendredi' => Carbon::FRIDAY,
        ];

        $today = Carbon::today();

        // Calculer le vendredi de la semaine actuelle
        if ($today->dayOfWeek <= Carbon::FRIDAY) {
            // Nous sommes avant ou le vendredi de la semaine actuelle
            $currentFriday = $today->copy()->next(Carbon::FRIDAY);
        } else {
            // Nous sommes après le vendredi, donc vendredi de la semaine prochaine
            $currentFriday = $today->copy()->addWeek()->next(Carbon::FRIDAY);
        }

        // Calculer le lundi suivant ce vendredi
        $nextMonday = $currentFriday->copy()->addDay(); // Lundi suivant le vendredi

        $dates = [];

        foreach ($activeDays as $day) {
            if (isset($daysMapping[$day])) {
                $date = $nextMonday->copy()->next($daysMapping[$day])->startOfDay();
                $dates[$day] = $date;
            }
        }

        return view('admin.ajouter_menu', compact('dates'));
    }

    public function storeWeeklyMenu(Request $request)
    {
        $menus = $request->input('menus');

        // Calculer la date du début de la semaine prochaine
        $today = Carbon::today();
        $startOfNextWeek = $today->copy()->addWeeks(1)->startOfWeek();

        // Vérifier si la semaine est déjà configurée
        $semaine = Semaine::where('date_debut', $startOfNextWeek->format('Y-m-d'))->first();

        if ($semaine) {
            // Si la semaine est déjà configurée, afficher un message d'erreur
            return redirect()->route('admin.show_weekly_menu_form')->with('error', 'Semaine déjà configurée !');
        }

        // Créer une nouvelle semaine
        $semaine = Semaine::create(['date_debut' => $startOfNextWeek->format('Y-m-d')]);

        // Ajouter les jours et les plats
        foreach ($menus as $date => $pack) {
            $date = Carbon::parse($date);

            // Déterminer le nom du jour en français pour l'énumération
            $dayInFrench = $date->translatedFormat('l');

            // Si vous utilisez un enum en anglais, remplacez les valeurs ci-dessous en conséquence
            $dayMapping = [
                'Monday' => 'lundi',
                'Tuesday' => 'mardi',
                'Wednesday' => 'mercredi',
                'Thursday' => 'jeudi',
                'Friday' => 'vendredi',
            ];

            // Assurez-vous que la valeur est correcte
            $dayEnum = isset($dayMapping[$dayInFrench]) ? $dayMapping[$dayInFrench] : $dayInFrench;

            // Vérifier si le jour existe déjà pour cette semaine
            $jour = Jour::where('semaine_id', $semaine->id)
                        ->whereDate('date', $date->format('Y-m-d'))
                        ->first();

            if (!$jour) {
                // Ajouter le jour
                $jour = Jour::create([
                    'semaine_id' => $semaine->id,
                    'date' => $date->format('Y-m-d'),
                    'jour' => $dayEnum // Utiliser le nom du jour correct
                ]);
            }

            // Ajouter ou mettre à jour le plat
            Plat::updateOrCreate(
                ['jour_id' => $jour->id, 'titre' => $pack],
                ['titre' => $pack]
            );
        }


        return redirect()->route('admin.show_weekly_menu_form')->with('success', 'Menus enregistrés avec succès !');
    }
    public function downloadPDF(Request $request, $weekId)
    {
        $week = Semaine::with('jours.plats')->findOrFail($weekId);
        $week->date_debut = \Carbon\Carbon::parse($week->date_debut); // Assurez-vous que c'est un objet Carbon
        $pdf = Pdf::loadView('pdf.menu', ['week' => $week]);
        return $pdf->download('menu_semaine_' . $week->date_debut->format('Y_m_d') . '.pdf');
    }






}


