<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChangeReminderMail;


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
        // Tugas harian untuk mengirim pengingat ubah password
        $schedule->call(function () {
            $users = User::where(function($query) {
                $query->whereNull('password_changed_at')
                      ->orWhere('password_changed_at', '<', now()->subDays(7));
            })->get();

            foreach ($users as $user) {
                Mail::to($user->email)->send(new PasswordChangeReminderMail($user));
            }
        })->daily();
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
