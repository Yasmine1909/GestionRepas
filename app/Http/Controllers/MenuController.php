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
            $today = Carbon::today();
            $currentDayOfWeek = $today->dayOfWeek;

            if ($currentDayOfWeek >= Carbon::FRIDAY) {
                $startOfWeek = $today->copy()->addWeeks(2)->startOfWeek(Carbon::MONDAY);
            } else {
                $startOfWeek = $today->copy()->addWeeks(1)->startOfWeek(Carbon::MONDAY);
            }

            $weekStartFormatted = $startOfWeek->format('Y-m-d');
            $week = Semaine::where('date_debut', $weekStartFormatted)->first();

            $disabledDays = [];
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

            return view('FrontOffice.ajouter_menu', compact('weekStartFormatted', 'disabledDays'));
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
            'plat_title_Samedi' => 'nullable|string',
            'plat_title_Dimanche' => 'nullable|string',
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

        $today = Carbon::today();

        if ($today->isFriday() || $today->isSaturday() || $today->isSunday()) {
            $weekStartDate = $today->copy()->addWeeks(2)->startOfWeek();
        } else {
            $weekStartDate = $today->copy()->addWeeks(1)->startOfWeek();
        }

        $weekStartFormatted = $weekStartDate->format('Y-m-d');

        $existingWeek = Semaine::where('date_debut', $weekStartFormatted)->first();
        if ($existingWeek) {
            return redirect()->back()->with('error', 'Cette semaine est déjà configurée')->withInput();
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

    public function storeWeeklyMenu(Request $request)
    {
        $menus = $request->input('menus');

        $today = Carbon::today();
         if ($today->isFriday() || $today->isSaturday() || $today->isSunday()) {
            $startOfNextWeek = $today->copy()->addWeeks(2)->startOfWeek();
        } else {
            $startOfNextWeek = $today->copy()->addWeeks(1)->startOfWeek();
        }

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

    public function downloadPDF(Request $request, $weekId)
    {
        $week = Semaine::with('jours.plats')->findOrFail($weekId);
        $week->date_debut = Carbon::parse($week->date_debut);
        $pdf = Pdf::loadView('pdf.menu', ['week' => $week]);
        return $pdf->download('menu_semaine_' . $week->date_debut->format('Y_m_d') . '.pdf');
    }
}
