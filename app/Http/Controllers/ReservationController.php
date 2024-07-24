<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Jour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Récupérer tous les jours du mois courant
        $jours = Jour::whereBetween('date', [$startOfMonth, $endOfMonth])->get();

        // Convertir les dates en objets Carbon
        foreach ($jours as $jour) {
            $jour->date = Carbon::parse($jour->date);
        }

        return view('FrontOffice.dashboard', compact('jours'));
    }



    public function getMenuForDate($date)
    {
        $jour = Jour::whereDate('date', $date)->with('plats')->first();

        if ($jour) {
            return response()->json([
                'plat_principal' => $jour->plats->first()->titre ?? null,
            ]);
        } else {
            return response()->json([
                'plat_principal' => null,
            ]);
        }
    }

    public function getReservations(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        $reservations = Reservation::whereBetween('date', [$startOfMonth, $endOfMonth])->get();

        return response()->json($reservations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jour_id' => 'required|exists:jours,id',
            'status' => 'required|in:réservé,disponible,non disponible',
            'reason' => 'nullable|string',
        ]);

        $reservation = Reservation::updateOrCreate(
            ['user_id' => Auth::id(), 'jour_id' => $validated['jour_id']],
            $validated
        );

        return response()->json($reservation);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Réservation annulée']);
    }
}
