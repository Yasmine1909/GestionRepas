<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Import Log facade

class SendReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        $specificEmails = ['ykhatib@m2mgroup.com', 'omersoul@m2mgroup.com'];

        foreach ($specificEmails as $email) {
            // Log the email sending attempt
            Log::info("Attempting to send reminder email to: $email");

            try {
                Mail::raw($this->message, function ($mail) use ($email) {
                    $mail->to($email)
                        ->subject('Rappel de Disponibilité pour la Restauration');
                });

                // Log successful email sending
                Log::info("Successfully sent reminder email to: $email");

            } catch (\Exception $e) {
                // Log any errors that occur during sending
                Log::error("Failed to send reminder email to: $email. Error: " . $e->getMessage());
            }
        }
    }
}
