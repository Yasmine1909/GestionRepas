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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (Auth::check()) {
            $now = Carbon::now();
            $currentDayOfWeek = $now->dayOfWeek;

            if ($currentDayOfWeek === Carbon::FRIDAY || $currentDayOfWeek === Carbon::SATURDAY || $currentDayOfWeek === Carbon::SUNDAY) {
                $startOfReservableWeek = $now->copy()->addWeeks(2)->startOfWeek();
                $endOfReservableWeek = $now->copy()->addWeeks(2)->endOfWeek();
            } else {
                $startOfReservableWeek = $now->copy()->addWeek()->startOfWeek();
                $endOfReservableWeek = $now->copy()->addWeek()->endOfWeek();
            }

            $startOfDisplayWeek = $startOfReservableWeek->copy()->subWeeks(2);
            $endOfDisplayWeek = $endOfReservableWeek->copy()->addWeeks(1);

            $userId = Auth::id();
            $reservations = Reservation::where('user_id', $userId)->get();
            $reservations = Reservation::all();
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
            return redirect()->route('connexion');
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

                app(NotificationController::class)->storeReservationNotification($reservation->id);

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                Log::error('Erreur lors de la réservation : ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Erreur lors de la réservation'], 500);
            }
        }

        return response()->json(['success' => false, 'message' => 'Plat non trouvé'], 400);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'status' => 'required|string',
            'reason' => 'nullable|string'
        ]);

        $userId = Auth::id();
        $reservation = Reservation::updateOrCreate(
            ['date' => $request->date, 'user_id' => $userId],
            ['status' => $request->status, 'reason' => $request->reason]
        );

        return response()->json(['message' => 'Réservation enregistrée avec succès', 'success' => true], 200);
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $userId = Auth::id();
        $reservation = Reservation::where('user_id', $userId)
            ->where('date', $request->date)
            ->first();

        if ($reservation) {
            try {
                $reservation->delete();
                $date = Carbon::parse($reservation->date);

                $notification = Notification::create([
                    'user_id' => $reservation->user_id,
                    'type' => 'danger',
                    'message' => 'Votre réservation pour le ' . $date->format('d-m-Y') . ' a été annulée.'
                ]);

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
        $userId = Auth::id();

        $reservedDates = Reservation::where('user_id', $userId)->pluck('date')->toArray();

        foreach ($days as $day) {
            $date = Carbon::parse($day['date'])->format('Y-m-d');

            if (in_array($date, $reservedDates)) {
                continue;
            }

            $plat = Plat::whereHas('jour', function ($query) use ($date) {
                $query->where('date', $date);
            })->first();

            if ($plat) {
                $reservation = Reservation::updateOrCreate(
                    ['user_id' => $userId, 'date' => $date],
                    ['status' => 'available', 'plat_id' => $plat->id]
                );

                app(NotificationController::class)->storeReservationNotification($reservation->id);
            }
        }

        return response()->json(['success' => true]);
    }
}
