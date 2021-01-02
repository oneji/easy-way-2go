<?php

namespace App\Http\Services;

use App\Http\JsonRequests\CancelOrderRequest;
use App\Http\JsonRequests\StoreOrderRequest;
use App\Http\Services\PassengerService;
use App\Http\Services\PackageService;
use Carbon\Carbon;
use App\Package;
use App\Order;
use App\OrderStatus;
use App\PaymentMethod;
use App\PaymentStatus;
use App\Transport;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $tripService;
    protected $transactionService;

    /**
     * OrderService constructor
     * 
     * @param \App\Http\Services\TripService $tripService
     * @param \App\Http\Services\TransactionService $transactionService
     */
    public function __construct(TripService $tripService, TransactionService $transactionService)
    {
        $this->tripService = $tripService;
        $this->transactionService = $transactionService;
    }

    /**
     * Get all orders
     * 
     * @return collection
     */
    public function all()
    {
        return Order::with([ 'country_from', 'country_to' ])->get();
    }

    /**
     * Get a specific order
     * 
     * @param int $id
     */
    public function getById($id)
    {
        return Order::with([ 'country_from', 'country_to', 'cargos', 'passengers', 'packages', 'payment_method', 'addresses' ])
            ->leftJoin('moving_data', 'moving_data.order_id', 'orders.id')
            ->select(
                'orders.*',
                'moving_data.from_floor',
                'moving_data.to_floor',
                'moving_data.time',
                'moving_data.movers_count',
                'moving_data.parking',
                'moving_data.parking_working_hours'
            )
            ->find($id);
    }

    /**
     * Store a newly created order
     * 
     * @param \App\Http\JsonRequests\StoreOrderRequest $request
     */
    public function store(StoreOrderRequest $request)
    {
        // Create a trip an attach order to it
        $trip = $this->tripService->findOrCreate([
            'transport_id' => $request->transport_id,
            'route_id' => $request->route_id,
            'status_id' => OrderStatus::getFuture()->id,
            'date' => Carbon::parse($request->date),
            'time' => '00:00',
            'from_country_id' => $request->from_country,
            'to_country_id' => $request->to_country,
            'from_address' => $request->from_address,
            'to_address' => $request->to_address,
        ]);

        $order = new Order($request->all());
        $order->date = Carbon::parse($request->date);
        $order->client_id = auth('client')->user()->id;
        $order->order_status_id = OrderStatus::getFuture()->id;
        $order->trip_id = $trip->id;
        $order->payment_status_id = PaymentStatus::getNotPaid()->id;
        $order->save();

        if($order->order_type === 'moving') {
            // Save moving data
            MovingDataService::store([
                'from_floor' => $request->from_floor,
                'to_floor' => $request->to_floor,
                'time' => $request->time,
                'movers_count' => $request->movers_count,
                'parking' => $request->parking,
                'parking_working_hours' => $request->parking_working_hours,
                'order_id' => $order->id,
                'cargos' => $request->cargos
            ]);
        } else {
            if(isset($request->passengers)) {
                PassengerService::attachToOrder($request->passengers, $order->id);
            }
    
            if(isset($request->package_dimensions_type)) {
                if($request->package_dimensions_type === Package::TYPE_SAME) {
                    PackageService::attachSameToOrder($request->package, $request->packages_count, $order->id);
                } else {
                    PackageService::attachDifferentToOrder($request->packages, $order->id);
                }
            }

            // Save addresses for the order
            if(isset($request->addresses)) {
                $order->addresses()->attach($request->addresses);
            }

            // Attach drivers separately to order
            $driverIds = DB::table('driver_transport')->where('transport_id', $request->transport_id)->pluck('driver_id');
        }

        $trip->drivers()->sync($driverIds);

        return $order;
    }

    /**
     * Cancel order
     * 
     * @param \App\Http\JsonRequests\CancelOrderRequest
     */
    public function cancel(CancelOrderRequest $request)
    {
        $order = Order::find($request->order_id);
        $order->order_status_id = OrderStatus::getCancelled()->id;
        $order->cancellation_reason = $request->reason;
        $order->save();

        return $order;
    }

    /**
     * Approve order
     * 
     * @param int $id
     */
    public function approve($id)
    {
        $order = Order::find($id);
        $order->approved = 1;
        
        if($order->payment_method_id === PaymentMethod::getCash()->id) {
            $order->payment_status_id = PaymentStatus::getPaid()->id;
            
            $transport = Transport::find($order->transport_id);
            $transport->balance += $order->total_price;
            $transport->save();

            $this->transactionService->store([
                'payment_method_id' => $order->payment_method_id,
                'order_id' => $order->id,
                'amount' => $order->total_price,
                'type' => 'income',
                'date' => Carbon::now()
            ]);
        }

        $order->save();

        return $order;
    }
}