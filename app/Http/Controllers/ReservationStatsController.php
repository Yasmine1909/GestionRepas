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
            return redirect()->route('login');
        }
    }

    public function fetchStats(Request $request)
    {
        $date = $request->input('date');
        $date = Carbon::parse($date);

        // Récupérer les réservations pour la date sélectionnée
        $reservations = Reservation::whereDate('date', $date)->get();

        // Total des utilisateurs
        $totalUsers = User::count();

        // Utilisateurs ayant réservé
        $confirmedReservations = $reservations->where('status', 'available')->pluck('user_id');
        $notAvailableUsers = $reservations->where('status', 'unavailable')->pluck('user_id');

        // Trouver les utilisateurs qui n'ont pas encore répondu
        $respondedUserIds = $confirmedReservations->merge($notAvailableUsers);
        $noResponseUsers = User::whereNotIn('id', $respondedUserIds)->get();

        // Formater les données pour la réponse JSON
        $data = [
            'totalUsers' => $totalUsers,
            'confirmedList' => User::whereIn('id', $confirmedReservations)->get()->map(function($user) {
                return [
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'status' => 'Confirmé'
                ];
            }),
            'notAvailableList' => User::whereIn('id', $notAvailableUsers)->get()->map(function($user) {
                return [
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'status' => 'Non Disponible',
                    'reason' => $user->reason // Assurez-vous que 'reason' est bien défini dans le modèle User
                ];
            }),
            'noResponseList' => $noResponseUsers->map(function($user) {
                return [
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'status' => 'Pas Encore Répondu'
                ];
            }),
        ];

        return response()->json($data);
    }

    public function fetchHistory()
    {
        // Récupérer les réservations passées
        $pastDates = Reservation::selectRaw('DATE(date) as date, COUNT(*) as total, SUM(status = "available") as confirmed, SUM(status = "unavailable") as not_available')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Formater les données pour la réponse JSON
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
        $perPage = 5; // Nombre de semaines par page
        $page = $request->input('page', 1); // Numéro de la page, par défaut 1
        $weeks = Semaine::orderBy('date_debut', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($weeks);
    }

    public function downloadWeekPdf($weekId)
    {
        // Récupère la semaine avec les jours, plats et réservations associés
        $week = Semaine::with('jours.plats.reservations')->findOrFail($weekId);

        // Préparer les données pour le PDF
        $data = [
            'week' => $week
        ];

        // Charge la vue PDF avec les données
        $pdf = PDF::loadView('pdf.weekly-menu', $data);

        return $pdf->download('menu-semaine-'.$week->date_debut.'.pdf');
    }

    public function downloadConfirmedPdf(Request $request)
    {
        $date = $request->input('date');

        // Fetch reservations based on the date
        $reservations = $this->fetchReservationsByDate($date);

        // Prepare data for the PDF
        $data = [
            'reservations' => $reservations,
            'date' => $date
        ];

        // Load the view and generate the PDF
        $pdf = PDF::loadView('pdf.confirmed-reservations', $data);

        return $pdf->download('confirmed-reservations-'.$date.'.pdf');
    }

    // Define the method to fetch reservations by date
    private function fetchReservationsByDate($date)
    {
        return Reservation::whereDate('date', $date)
            ->where('status', 'available')
            ->get();
    }

    public function downloadNotAvailablePdf(Request $request)
    {
        $date = $request->input('date');
        $reservations = $this->fetchReservationsByStatus($date, 'unavailable'); // Assume this method fetches reservations by status

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

    // Fetch users who do not have reservations for the given date
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
    // Get users who have no reservations for the specified date
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
