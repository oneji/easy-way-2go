<?php

namespace App\Http\Services;

use App\Client;
use App\Driver;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderApprovedNotification;
use App\Notifications\OrderCancelledNotification;
use App\Notifications\OrderNewTransportNotification;
use App\Order;

class NotificationService
{
    /**
     * Notify user's about a new order
     * 
     * @param Order $order
     */
    public static function newOrder(Order $order)
    {
        $users = Driver::join('driver_trip', 'driver_trip.driver_id', 'drivers.id')
            ->select('drivers.*')
            ->where('driver_trip.trip_id', $order->trip_id)
            ->get();

        foreach($users as $user) {
            $user->notify(new NewOrderNotification($order));
        }
    }

    /**
     * Notify order owner that the order is approved
     * 
     * @param Order $order
     */
    public static function orderApproved(Order $order)
    {
        $user = Client::find($order->client_id);
        $user->notify(new OrderApprovedNotification($order));
    }

    /**
     * Notify order owner that the order is cancelled
     * 
     * @param Order $order
     */
    public static function orderCancelled(Order $order)
    {
        $user = Client::find($order->client_id);
        $user->notify(new OrderCancelledNotification($order));
    }

    /**
     * Notify order owner that the new transport has been set
     * 
     * @param Order $order
     */
    public static function orderNewTransport(Order $order)
    {
        $user = Client::find($order->client_id);
        $user->notify(new OrderNewTransportNotification($order));
    }
}