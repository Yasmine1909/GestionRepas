<?php

namespace App\Http\Controllers;

use App\Models\Jour;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Plat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

use App\Models\Semaine;

class NotificationController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
        $this->middleware('auth');
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(20);

        return view('FrontOffice.notifications', compact('notifications'));
    } else {
        return redirect()->route('login');
    }
    }

    public function storeReservationNotification($reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            Log::error('Réservation non trouvée pour ID : ' . $reservationId);
            return;
        }

        $date = $reservation->date instanceof Carbon ? $reservation->date : Carbon::parse($reservation->date);

        if ($reservation->status == 'available') {
            $plat = Plat::find($reservation->plat_id);

            if (!$plat) {
                Log::error('Plat non trouvé pour ID : ' . $reservation->plat_id);
                return;
            }

            $message = 'Réservation confirmée pour le ' . $date->format('d-m-Y') . ' avec comme menu : ' . $plat->titre;
        } else {
            $message = 'Vous avez confirmé que vous n\'êtes pas disponible le ' . $date->format('d-m-Y') . ' pour raison : ' . $reservation->reason;
        }

        $notification = Notification::create([
            'user_id' => $reservation->user_id,
            'type' => 'success',
            'message' => $message
        ]);

        Mail::to($reservation->user->email)->send(new NotificationMail($notification));
    }



    public function storeCancellationNotification($reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            Log::error('Réservation non trouvée pour ID : ' . $reservationId);
            return;
        }

        $date = $reservation->date instanceof Carbon ? $reservation->date : Carbon::parse($reservation->date);

        try {
            $notification = Notification::create([
                'user_id' => $reservation->user_id,
                'type' => 'danger',
                'message' => 'Votre réservation pour le ' . $date->format('d-m-Y') . ' a été annulée.'
            ]);

            Log::info('Notification d\'annulation créée avec succès : ' . $notification->id);

            Mail::to($reservation->user->email)->send(new NotificationMail($notification));

            Log::info('Email d\'annulation envoyé avec succès à : ' . $reservation->user->email);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la notification ou de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }
    public function search(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $userId = Auth::id();
    $query = $request->input('query');

    $notifications = Notification::where('user_id', $userId)
                                  ->where(function($q) use ($query) {
                                      $q->where('message', 'LIKE', "%$query%")
                                        ->orWhereDate('created_at', 'LIKE', "%$query%");
                                  })
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(20);

    return view('FrontOffice.notifications', compact('notifications'));
}




}



