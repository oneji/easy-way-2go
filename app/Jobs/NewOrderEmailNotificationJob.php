<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NewOrderEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $drivers = DB::table('driver_trip')
            ->join('drivers', 'drivers.id', 'driver_trip.driver_id')
            ->select('drivers.email')
            ->whereTripId($this->order->trip_id)
            ->get();

        $emails = $drivers->pluck('email');

        foreach ($emails as $email) {
            Mail::to($email)->send(new SendMail($email, ''));
        }
    }
}
