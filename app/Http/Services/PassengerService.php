<?php

namespace App\Http\Services;

use Carbon\Carbon;
use App\Passenger;
use App\Order;

class PassengerService
{
    /**
     * Attach passengers to the order
     * 
     * @param array $passengersData
     * @param int $orderId
     */
    public static function attachToOrder($passengersData, $orderId)
    {
        $passengersToInsert = [];
        foreach($passengersData as $passenger) {
            $passengersToInsert[] = [
                'gender' => $passenger['gender'],
                'first_name' => $passenger['first_name'],
                'last_name' => $passenger['last_name'],
                'birthday' => Carbon::parse($passenger['birthday']),
                'nationality' => $passenger['nationality'],
                'id_card' => $passenger['id_card'],
                'passport_number' => $passenger['passport_number'],
                'passport_expires_at' => Carbon::parse($passenger['passport_expires_at']),
                'order_id' => $orderId
            ];
        }

        Passenger::insert($passengersToInsert);
    }
}