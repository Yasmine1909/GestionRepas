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

class ReservationController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfDisplayWeek = $now->copy()->startOfWeek()->subWeeks(2);
        $endOfDisplayWeek = $now->copy()->endOfWeek()->addWeeks(2);
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
            'currentWeekStart' => $now->startOfWeek(),
            'reservations' => $reservations,
            'currentWeekEnd' => $now->endOfWeek()
        ]);
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





public function validateReservation(Request $request)
{
    $data = $request->validate([
        'date' => 'required|date',
        'status' => 'required|string',
        'reason' => 'nullable|string',
    ]);

    // Convertir la date en Carbon
    $date = Carbon::parse($data['date']);
    $jour = Jour::where('date', $date->format('Y-m-d'))->first();

    if ($jour) {
        $jour->status = $data['status'];
        $jour->reason = $data['reason'] ?? null;
        $jour->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}

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
                // Assurez-vous que la réservation est supprimée avec succès
                $reservation->delete();

                // Assurez-vous que la date est un objet Carbon
                $date = $reservation->date instanceof Carbon
                    ? $reservation->date
                    : Carbon::parse($reservation->date);

                // Créer une notification pour l'annulation
                Notification::create([
                    'user_id' => $reservation->user_id,
                    'type' => 'danger',
                    'message' => 'Votre réservation pour le ' . $date->format('d-m-Y') . ' a été annulée.'
                ]);

                return response()->json(['message' => 'Réservation annulée avec succès'], 200);
            } catch (\Exception $e) {
                Log::error('Erreur lors de l\'annulation de la réservation ou de la création de la notification : ' . $e->getMessage());
                return response()->json(['message' => 'Erreur lors de l\'annulation de la réservation ou de la notification'], 500);
            }
        }

        return response()->json(['message' => 'Réservation non trouvée'], 400);
    }



    public function reserveWeek()
    {
        $user = auth()->user();
        $startOfWeek = Carbon::now()->addWeek()->startOfWeek();
        $endOfWeek = Carbon::now()->addWeek()->endOfWeek();

        $jours = Jour::whereBetween('date', [$startOfWeek, $endOfWeek])
                     ->whereHas('plats')
                     ->get();

        if ($jours->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Aucun plat trouvé pour la semaine suivante'], 400);
        }

        foreach ($jours as $jour) {
            $reservation = Reservation::where('user_id', $user->id)
                                      ->where('date', $jour->date)
                                      ->first();

            if (!$reservation) {
                Reservation::create([
                    'user_id' => $user->id,
                    'date' => $jour->date,
                    'status' => 'available'
                ]);
            }
        }

        return response()->json(['message' => 'Réservations de la semaine enregistrées avec succès'], 200);
    }
}
