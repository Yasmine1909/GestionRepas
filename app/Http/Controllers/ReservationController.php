<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jour;
use App\Models\Reservation;
use App\Models\Plat;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\Semaine;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;
class ReservationController extends Controller
{
    public function index()
{
    if (Auth::check()) {
    $this->middleware('auth');
    $now = Carbon::now();
    $currentDayOfWeek = $now->dayOfWeek;

    if ($currentDayOfWeek === Carbon::FRIDAY) {
        // Si aujourd'hui est vendredi, la semaine réservable commence dans deux semaines
        $startOfReservableWeek = $now->copy()->addWeeks(2)->startOfWeek();
        $endOfReservableWeek = $now->copy()->addWeeks(2)->endOfWeek();
    } elseif ($currentDayOfWeek === Carbon::SATURDAY) {
        // Si aujourd'hui est samedi, la semaine réservable commence dans deux semaines
        $startOfReservableWeek = $now->copy()->addWeeks(2)->startOfWeek();
        $endOfReservableWeek = $now->copy()->addWeeks(2)->endOfWeek();
    } elseif ($currentDayOfWeek === Carbon::SUNDAY) {
        // Si aujourd'hui est dimanche, la semaine réservable commence dans deux semaines
        $startOfReservableWeek = $now->copy()->addWeeks(2)->startOfWeek();
        $endOfReservableWeek = $now->copy()->addWeeks(2)->endOfWeek();
    } else {
        // Pour tous les autres jours (lundi à jeudi), la semaine réservable commence la semaine prochaine
        $startOfReservableWeek = $now->copy()->addWeek()->startOfWeek();
        $endOfReservableWeek = $now->copy()->addWeek()->endOfWeek();
    }

    // Définir les semaines précédentes et suivantes à afficher
    $startOfDisplayWeek = $startOfReservableWeek->copy()->subWeeks(2);
    $endOfDisplayWeek = $endOfReservableWeek->copy()->addWeeks(1);

    $user = auth()->user();
    $reservations = Reservation::where('user_id', $user->id)->get();

    $jours = Jour::whereBetween('date', [$startOfDisplayWeek, $endOfDisplayWeek])
        ->with('plats')
        ->get()
        ->keyBy(function($item) {
            return Carbon::parse($item->date)->format('Y-m-d');
        });

    $calendarDays = collect();
    $currentDay = $startOfDisplayWeek->copy();
    while ($currentDay->lte($endOfDisplayWeek)) {
        $calendarDays->push($currentDay->copy());
        $currentDay->addDay();
    }

    return view('FrontOffice.dashboard', [
        'calendarDays' => $calendarDays,
        'jours' => $jours,
        'currentWeekStart' => $startOfReservableWeek,
        'reservations' => $reservations,
        'currentWeekEnd' => $endOfReservableWeek
    ]);
} else {
    // Rediriger ou gérer les utilisateurs non connectés
    return redirect()->route('login');
}
}


    public function downloadMenu($startDate)
    {
        $semaine = Semaine::where('date_debut', $startDate)->with('jours.plats')->first();
        if (!$semaine) {
            return redirect()->back()->with('error', 'Semaine non trouvée.');
        }

        $pdf = Pdf::loadView('pdf.menuu', compact('semaine'));
        return $pdf->download('menu-semaine-' . $startDate . '.pdf');
    }

    public function reserve(Request $request)
    {
        $userId = Auth::id();
        $date = Carbon::parse($request->input('date'));

        $plat = Plat::whereHas('jour', function ($query) use ($date) {
            $query->where('date', $date->format('Y-m-d'));
        })->first();

        if ($plat) {
            try {
                $reservation = Reservation::updateOrCreate(
                    ['user_id' => $userId, 'date' => $date->format('Y-m-d')],
                    ['plat_id' => $plat->id, 'status' => $request->input('status'), 'reason' => $request->input('reason')]
                );

                // Créer une notification pour la réservation
                app(NotificationController::class)->storeReservationNotification($reservation->id);

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de la réservation : ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Erreur lors de la réservation'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Plat non trouvé'], 400);
    }





// public function validateReservation(Request $request)
// {
//     $data = $request->validate([
//         'date' => 'required|date',
//         'status' => 'required|string',
//         'reason' => 'nullable|string',
//     ]);

//     // Convertir la date en Carbon
//     $date = Carbon::parse($data['date']);
//     $jour = Jour::where('date', $date->format('Y-m-d'))->first();

//     if ($jour) {
//         $jour->status = $data['status'];
//         $jour->reason = $data['reason'] ?? null;
//         $jour->save();

//         return response()->json(['success' => true]);
//     }

//     return response()->json(['success' => false]);
// }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|string',
            'reason' => 'nullable|string'
        ]);

        $user = auth()->user();
        $reservation = Reservation::updateOrCreate(
            ['date' => $request->date, 'user_id' => $user->id],
            ['status' => $request->status, 'reason' => $request->reason]
        );

        return response()->json(['message' => 'Réservation enregistrée avec succès', 'success' => true], 200);
    }



    public function cancel(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $user = auth()->user();
        $reservation = Reservation::where('user_id', $user->id)
            ->where('date', $request->date)
            ->first();

        if ($reservation) {
            try {
                $reservation->delete();
                $date = Carbon::parse($reservation->date);

                // Création de la notification
                $notification = Notification::create([
                    'user_id' => $reservation->user_id,
                    'type' => 'danger',
                    'message' => 'Votre réservation pour le ' . $date->format('d-m-Y') . ' a été annulée.'
                ]);

                // Envoi de l'email d'annulation
                Mail::to($reservation->user->email)->send(new NotificationMail($notification));

                Log::info('Réservation annulée et email envoyé avec succès à ' . $reservation->user->email);
                return response()->json(['message' => 'Réservation annulée avec succès'], 200);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'annulation de la réservation ou de la création de la notification : ' . $e->getMessage());
                return response()->json(['message' => 'Erreur lors de l\'annulation de la réservation ou de la notification'], 500);
            }
        }

        return response()->json(['message' => 'Réservation non trouvée'], 400);
    }





    public function reserveWeek(Request $request)
    {
        $days = $request->input('days');
        $userId = auth()->id();
        $reservedDates = Reservation::where('user_id', $userId)->pluck('date')->toArray();

        foreach ($days as $day) {
            $date = Carbon::parse($day['date'])->format('Y-m-d');

            // Vérifier si la date est déjà réservée
            if (in_array($date, $reservedDates)) {
                continue; // Passer à la date suivante si elle est déjà réservée
            }

            // Trouver le plat correspondant au jour donné
            $plat = Plat::whereHas('jour', function ($query) use ($date) {
                $query->where('date', $date);
            })->first();

            if ($plat) {
                // Créer ou mettre à jour la réservation pour ce jour avec le plat associé
                $reservation = Reservation::updateOrCreate(
                    ['user_id' => $userId, 'date' => $date],
                    ['status' => 'available', 'plat_id' => $plat->id]
                );

                // Créer une notification pour la réservation
                app(NotificationController::class)->storeReservationNotification($reservation->id);
            }
        }

        return response()->json(['success' => true]);
    }


}
