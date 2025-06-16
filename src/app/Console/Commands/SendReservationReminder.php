<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminderMail;
use Carbon\Carbon;

class SendReservationReminder extends Command
{
    protected $signature = 'reminder:send-reservations';
    protected $description = '予約当日のリマインダーメールを送信';

    public function handle()
    {
        $today = Carbon::today();

        $reservations = Reservation::with('user')
        ->whereDate('reservation_datetime', $today)
            ->get();

        foreach ($reservations as $reservation) {
            Mail::to($reservation->user->email)
                ->send(new ReservationReminderMail($reservation));
        }

        $this->info("Sent " . $reservations->count() . " reminders.");
    }
}
