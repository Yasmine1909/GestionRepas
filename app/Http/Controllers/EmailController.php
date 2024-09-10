<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Jobs\SendReminderEmail;
class EmailController extends Controller
{

public function sendReminderEmails(Request $request)
{
    $premierRappelMessage = "Bonjour,

    Ceci est un premier rappel pour indiquer votre disponibilité pour les jours de restauration de la semaine prochaine.


    Merci de remplir vos disponibilités avant la fin de la semaine.


Merci,

M2M GROUP.";
    $dernierRappelMessage = "Bonjour,

    Ceci est un dernier rappel pour indiquer votre disponibilité pour les jours de restauration de la semaine prochaine.

    
    Merci de remplir vos disponibilités avant la fin de la journée.


Merci,

M2M GROUP.";

    // Déterminer le message à envoyer
    if ($request->reminder_type == 'premier_rappel') {
        $message = $premierRappelMessage;
    } elseif ($request->reminder_type == 'dernier_rappel') {
        $message = $dernierRappelMessage;
    } else {
        $message = $request->custom_message;
    }

    // Dispatcher le job
    SendReminderEmail::dispatch($message);

    return redirect()->back()->with('success', 'Le rappel a été envoyé avec succès.');
}

}
