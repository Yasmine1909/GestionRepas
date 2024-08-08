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
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('FrontOffice.notifications', compact('notifications'));
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

        // Envoi de l'email
        Mail::to($reservation->user->email)->send(new NotificationMail($notification));
    }

    // public function storeCancellationNotification($reservationId)
    // {
    //     // Récupérer la réservation
    //     $reservation = Reservation::find($reservationId);

    //     if (!$reservation) {
    //         Log::error('Réservation non trouvée pour ID : ' . $reservationId);
    //         return;
    //     }

    //     // Assurez-vous que la date est un objet Carbon
    //     $date = $reservation->date instanceof Carbon
    //         ? $reservation->date
    //         : Carbon::parse($reservation->date);

    //     // Créer une notification pour l'annulation
    //     try {
    //         Notification::create([
    //             'user_id' => $reservation->user_id,
    //             'type' => 'danger',
    //             'message' => 'Votre réservation pour le ' . $date->format('d-m-Y') . ' a été annulée.'
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Erreur lors de la création de la notification : ' . $e->getMessage());
    //     }
    // }

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

            // Envoi de l'email
            Mail::to($reservation->user->email)->send(new NotificationMail($notification));

            Log::info('Email d\'annulation envoyé avec succès à : ' . $reservation->user->email);
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la notification ou de l\'envoi de l\'email : ' . $e->getMessage());
        }
    }

}



