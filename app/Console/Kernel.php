<?php

namespace App\Console;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMondayEmail;
use App\Mail\ReminderThursdayEmail;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $users = User::all(); // Assurez-vous que votre modèle User est bien configuré
            foreach ($users as $user) {
                Mail::to($user->email)->send(new ReminderMondayEmail());
            }
        })->mondays()->at('10:00');

        $schedule->call(function () {
            $users = User::all();
            foreach ($users as $user) {
                Mail::to($user->email)->send(new ReminderThursdayEmail());
            }
        })->thursdays()->at('10:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
