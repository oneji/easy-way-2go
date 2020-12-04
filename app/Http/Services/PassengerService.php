<?php

namespace App\Http\Services;

use App\Http\JsonRequests\StorePassengerRequest;
use App\Http\JsonRequests\UpdatePassengerRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Passenger;
use App\Order;

class PassengerService
{
    /**
     * Get client's all passengers
     * 
     * @param int $clientId
     */
    public function all($clientId, $name = null)
    {
        return Passenger::where('client_id', $clientId)
            ->when($name, function($query) use ($name) {
                $query->where('first_name', 'like', "%$name%")
                    ->orWhere('last_name', 'like', "%$name%");
            })
            ->get();
    }

    /**
     * Store a newly created passengers
     * 
     * @param   \App\Http\JsonRequests\StorePassengerRequest $request
     * @return  Passenger $passenger
     */
    public function store(StorePassengerRequest $request)
    {
        $passenger = new Passenger($request->all());
        $passenger->birthday = Carbon::parse($request->birthday);
        $passenger->passport_expires_at = Carbon::parse($request->passport_expires_at);
        $passenger->client_id = auth('client')->user()->id;
        $passenger->save();

        return $passenger;
    }
    
    /**
     * Update an existing passenger
     * 
     * @param   \App\Http\JsonRequests\UpdatePassengerRequest $request
     * @param   int $id
     * @return  Passenger $passenger
     */
    public function update(UpdatePassengerRequest $request, $id)
    {
        $passenger = Passenger::find($id);

        if($passenger) {
            $passenger->gender = $request->gender;
            $passenger->first_name = $request->first_name;
            $passenger->last_name = $request->last_name;
            $passenger->birthday = Carbon::parse($request->birthday);
            $passenger->nationality = $request->nationality;
            $passenger->id_card = $request->id_card;
            $passenger->passport_number = $request->passport_number;
            $passenger->passport_expires_at = Carbon::parse($request->passport_expires_at);
            $passenger->save();

            return $passenger;
        }
    }
    
    /**
     * Delete passenger
     * 
     * @param int $id
     */
    public function delete($id)
    {
        $passenger = Passenger::find($id);
        $passenger->deleted = 1;
        $passenger->save();
    }

    /**
     * Attach passengers to the order
     * 
     * @param array $passengersData
     * @param int $orderId
     */
    public static function attachToOrder($passengersData, $orderId)
    {
        foreach($passengersData as $passenger) {
            $passenger = new Passenger($passenger);
            $passenger->birthday = Carbon::parse($passenger['birthday']);
            $passenger->passport_expires_at = Carbon::parse($passenger['passport_expires_at']);

            if(auth('client')->check()) {
                $passenger->client_id = auth('client')->user()->id;
            } else {
                $passenger->client_id = null;
            }

            $passenger->save();

            DB::table('order_passenger')->insert([
                'order_id' => $orderId,
                'passenger_id' => $passenger->id
            ]);
        }
    }
}