<?php

namespace App\Http\Controllers;

use App\Models\Jour;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Plat;
use Carbon\Carbon;
use App\Models\Semaine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('FrontOffice.notifications', compact('notifications'));
    }

    public function storeReservationNotification($reservationId)
    {
        // Récupérer la réservation
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            // Gérer le cas où la réservation n'existe pas
            return;
        }

        // Assurez-vous que la date est un objet Carbon
        $date = $reservation->date instanceof Carbon
            ? $reservation->date
            : Carbon::parse($reservation->date);

        // Vérifier le statut de la réservation et créer le message en conséquence
        if ($reservation->status == 'available') {
            // Récupérer le plat associé à la réservation
            $plat = Plat::find($reservation->plat_id);

            if (!$plat) {
                // Gérer le cas où le plat n'existe pas
                return;
            }

            $message = 'Réservation confirmée pour le ' . $date->format('d-m-Y') . ' avec comme menu : ' . $plat->titre;
        } else {
            $message = 'Vous avez confirmé que vous n\'êtes pas disponible le ' . $date->format('d-m-Y') . ' pour raison : ' . $reservation->reason;
        }

        // Créer une notification
        Notification::create([
            'user_id' => $reservation->user_id,
            'type' => 'success',
            'message' => $message
        ]);
    }



public function storeCancellationNotification($reservationId)
{
    // Récupérer la réservation
    $reservation = Reservation::find($reservationId);

    if (!$reservation) {
        Log::error('Réservation non trouvée pour ID : ' . $reservationId);
        return;
    }

    // Assurez-vous que la date est un objet Carbon
    $date = $reservation->date instanceof Carbon
        ? $reservation->date
        : Carbon::parse($reservation->date);

    // Créer une notification pour l'annulation
    try {
        Notification::create([
            'user_id' => $reservation->user_id,
            'type' => 'danger',
            'message' => 'Votre réservation pour le ' . $date->format('d-m-Y') . ' a été annulée.'
        ]);
    } catch (\Exception $e) {
        Log::error('Erreur lors de la création de la notification : ' . $e->getMessage());
    }
}



}
