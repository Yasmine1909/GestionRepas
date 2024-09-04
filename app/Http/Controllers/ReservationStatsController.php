<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Semaine;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ReservationStatsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('BackOffice.reservation_stats');
        } else {
            return redirect()->route('admin.login');
        }
    }

    public function fetchStats(Request $request)
    {
        $date = $request->input('date');
        $date = Carbon::parse($date);

        $reservations = Reservation::whereDate('date', $date)->get();

        $totalUsers = User::count();

        $confirmedReservations = $reservations->where('status', 'available')->pluck('user_id');
        $notAvailableUsers = $reservations->where('status', 'unavailable')->pluck('user_id');

        $respondedUserIds = $confirmedReservations->merge($notAvailableUsers);
        $noResponseUsers = User::whereNotIn('id', $respondedUserIds)->get();

        $data = [
            'totalUsers' => $totalUsers,
            'confirmedList' => User::whereIn('id', $confirmedReservations)->get()->map(function($user) {
                return [
                    'name' => $user->name,

                    'email' => $user->email,
                    'status' => 'Confirmé'
                ];
            }),
            'notAvailableList' => User::whereIn('id', $notAvailableUsers)->get()->map(function($user) {
                return [
                    'name' => $user->name,

                    'email' => $user->email,
                    'status' => 'Non Disponible',
                    'reason' => $user->reason
                ];
            }),
            'noResponseList' => $noResponseUsers->map(function($user) {
                return [
                    'name' => $user->name,

                    'email' => $user->email,
                    'status' => 'Pas Encore Répondu'
                ];
            }),
        ];

        return response()->json($data);
    }

    public function fetchHistory()
    {
        $pastDates = Reservation::selectRaw('DATE(date) as date, COUNT(*) as total, SUM(status = "available") as confirmed, SUM(status = "unavailable") as not_available')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        $data = $pastDates->map(function($record) {
            return [
                'date' => Carbon::parse($record->date)->format('Y-m-d'),
                'confirmed' => $record->confirmed,
                'not_available' => $record->not_available,
                'no_response' => $record->total - $record->confirmed - $record->not_available,
            ];
        });

        return response()->json($data);
    }

    public function getWeeks(Request $request)
    {
        $perPage = 5;
        $page = $request->input('page', 1);
        $weeks = Semaine::orderBy('date_debut', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($weeks);
    }

    public function downloadWeekPdf($weekId)
    {
        $week = Semaine::with('jours.plats.reservations')->findOrFail($weekId);

        $data = [
            'week' => $week
        ];

        $pdf = PDF::loadView('pdf.weekly-menu', $data);

        return $pdf->download('menu-semaine-'.$week->date_debut.'.pdf');
    }

    public function downloadConfirmedPdf(Request $request)
    {
        $date = $request->input('date');

        $reservations = $this->fetchReservationsByDate($date);

        $data = [
            'reservations' => $reservations,
            'date' => $date
        ];

        $pdf = PDF::loadView('pdf.confirmed-reservations', $data);

        return $pdf->download('confirmed-reservations-'.$date.'.pdf');
    }

    private function fetchReservationsByDate($date)
    {
        return Reservation::whereDate('date', $date)
            ->where('status', 'available')
            ->get();
    }

    public function downloadNotAvailablePdf(Request $request)
    {
        $date = $request->input('date');
        $reservations = $this->fetchReservationsByStatus($date, 'unavailable');

        $pdf = PDF::loadView('pdf.not-available-reservations', [
            'reservations' => $reservations,
            'selectedDate' => $date,
            'totalCount' => $reservations->count()
        ]);

        return $pdf->download('not-available-reservations-'.$date.'.pdf');
    }

    public function downloadNoResponsePdf(Request $request)
{
    $date = $request->input('date');

    $usersWithNoResponse = $this->fetchUsersWithNoResponse($date);

    $pdf = PDF::loadView('pdf.no-response-reservations', [
        'reservations' => $usersWithNoResponse,
        'selectedDate' => $date,
        'totalCount' => $usersWithNoResponse->count()
    ]);

    return $pdf->download('no-response-reservations-'.$date.'.pdf');
}

private function fetchUsersWithNoResponse($date)
{
    $usersWithReservations = Reservation::whereDate('date', $date)
        ->pluck('user_id');

    return User::whereNotIn('id', $usersWithReservations)->get();
}


    private function fetchReservationsByStatus($date, $status)
    {
        return Reservation::whereDate('date', $date)
            ->where('status', $status)
            ->get();
    }
}
