<?php
namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
    //Laisser pour après POur pouvoir envoyer à tout le Monde
    
    // public function handle()
    //  $users = User::all();
    // {

    //     foreach ($users as $user) {
    //         Mail::raw($this->message, function ($mail) use ($user) {
    //             $mail->to($user->email)
    //                 ->subject('Rappel de Disponibilité');
    //         });
    //     }
    // }

    public function handle()
{
    $specificEmails = ['ykhatib@m2mgroup.com', 'omersoul@m2mgroup.com'];

    foreach ($specificEmails as $email) {
        Mail::raw($this->message, function ($mail) use ($email) {
            $mail->to($email)
                ->subject('Rappel de Disponibilité');
        });
    }
}

}
