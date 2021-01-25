<?php

namespace App\Http\Services;

use App\Expense;
use App\Http\JsonRequests\CancelTripRequest;
use App\Order;
use App\OrderStatus;
use App\Route;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripService
{
    protected $expenseService;

    /**
     * TripService constructor
     * 
     * @param \App\Http\Services\ExpenseService $expenseService
     */
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Get all available trips
     * 
     * @param \Illumiante\Http\Request $request
     * @return collection
     */
    public function all(Request $request)
    {
        // Filtering params
        $carNumber = $request->query('car_number'); // string
        $orderType = $request->query('type');       // string
        $orderStatus = $request->query('status');   // integer: order_status_id
        $from = $request->query('from');            // string
        $to = $request->query('to');                // string
        
        // Get trips by transport id
        $trips = Trip::with([ 'from_country', 'to_country', 'status' ])
            ->leftJoin('transports', 'transports.id', 'trips.transport_id')
            ->select(
                'trips.id',
                'transports.car_number',
                'transports.passengers_seats',
                'transports.cubo_metres_available',
                'transports.kilos_available',
                'trips.date',
                'trips.time',
                'trips.from_address',
                'trips.to_address',
                'trips.type',
                'trips.status_id',
                'trips.from_country_id',
                'trips.to_country_id'
            )
            ->when($from, function($query, $from) {
                $query->where('date', '>=', Carbon::parse($from));
            })
            ->when($to, function($query, $to) {
                $query->where('date', '<=', Carbon::parse($to));
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('status_id', $orderStatus);
            })
            ->get();

        foreach ($trips as $trip) {
            $tripType = $trip->type;
            // Collecton trip stats
            $stat = Order::selectRaw('
                sum(passengers_count) as passengers,
                sum(packages_count) as packages,
                sum(total_price) as total_price,
                trip_id'
            )
            ->whereHas('addresses', function($query) use ($tripType) {
                $query->where('type', $tripType);
            })
            ->groupBy('trip_id')
            ->where('trip_id', $trip->id)
            ->first();

            if($stat) {
                $trip['passengers'] = $stat->passengers .'/'. $trip->passengers_seats;
                $trip['packages'] = $stat->packages .'/'. $trip->cubo_metres_available;
                $trip['total_price'] = $stat->total_price;
            } else {
                $trip['no_back'] = true;
            }
        }
        
        return $trips;
    }

    /**
     * Store a newly created trip
     * 
     * @param array $tripData
     */
    public function findOrCreate($tripData)
    {
        $trip = Trip::where([
            'transport_id' => $tripData['transport_id'],
            'route_id' => $tripData['route_id'],
            'date' => $tripData['date']
        ])->first();

        if($trip) return $trip;
        
        $route = Route::find($tripData['route_id']);
        $trip = new Trip($tripData);
        $trip->type = 'forward';
        $trip->from_address = $route->getCitiesByType('forward')['first']['address'];
        $trip->to_address = $route->getCitiesByType('forward')['last']['address'];
        $trip->save();

        return $trip;
    }

    /**
     * Set trip's drivers
     * 
     * @param int $id
     * @param int $driverId
     */
    public function setDriver($id, $driverId)
    {
        DB::table('driver_trip')->insert([
            'driver_id' => $driverId,
            'trip_id' => $id,
        ]);
    }

    /**
     * Set new tranport
     * 
     * @param int $id
     * @param int $transportId
     */
    public function setNewTransport($id, $transportId)
    {
        $trip = Trip::with('orders')->find($id);
        $trip->transport_id = $transportId;
        $trip->save();

        foreach ($trip->orders as $order) {
            $order->transport_id = $transportId;
            $order->save();

            NotificationService::orderNewTransport($order);
        }
    }

    /**
     * Cancel trip
     * 
     * @param \App\Http\JsonRequests\CancelTripRequest
     */
    public function cancel(CancelTripRequest $request)
    {
        $trip = Trip::find($request->trip_id);
        $trip->status_id = OrderStatus::getCancelled()->id;
        $trip->cancellation_reason = $request->reason;
        $trip->save();

        return $trip;
    }

    /**
     * Finish 1/2 of the trip
     * 
     * @param int $id
     * @param \App\Http\JsonRequests\FinishHalfTripRequest $request
     */
    public function finishHalf($request, $id)
    {
        $trip = Trip::find($id);
        $trip->status_id = OrderStatus::getHalfFinished()->id;
        $trip->fact_price = $request->fact_price;
        $trip->save();

        if(isset($request->expenses)) {
            $this->expenseService->store($request->expenses, $trip->id);
        }
    }

    /**
     * Change trips direction
     * 
     * @param int $id
     * @param string $direction
     */
    public function changeDirection($id, $direction)
    {
        $trip = Trip::with([ 'from_country', 'to_country', 'status' ])
            ->leftJoin('transports', 'transports.id', 'trips.transport_id')
            ->select(
                'trips.id',
                'transports.car_number',
                'transports.passengers_seats',
                'transports.cubo_metres_available',
                'transports.kilos_available',
                'trips.date',
                'trips.time',
                'trips.from_address',
                'trips.to_address',
                'trips.type',
                'trips.status_id',
                'trips.from_country_id',
                'trips.to_country_id'
            )
            ->where('trips.id', $id)
            ->first();
        $trip->type = $direction;
        $trip->save();

        // Collecton trip stats
        $stats = Order::selectRaw('
            sum(passengers_count) as passengers,
            sum(packages_count) as packages,
            sum(total_price) as total_price,
            trip_id'
        )
        ->whereHas('addresses', function($query) use ($direction) {
            $query->where('type', $direction);
        })
        ->where('trip_id', $trip->id)
        ->groupBy('trip_id')
        ->first();

        if($stats) {
            $trip['passengers'] = $stats->passengers .'/'. $trip->passengers_seats;
            $trip['packages'] = $stats->packages .'/'. $trip->cubo_metres_available;
            $trip['total_price'] = $stats->total_price;
        } else {
            $trip['no_back'] = true;
        }

        return $trip;
    }
    
    /**
     * Start boarding
     * 
     * @param int $id
     */
    public function startBoarding($id)
    {
        $trip = Trip::find($id);
        $trip->status_id = OrderStatus::getBoarding()->id;
        $trip->save();
    }

    /**
     * Get trip by id
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
     * @return  array
     */
    public function getById(Request $request, $id)
    {
        $trip = Trip::with('status')
            ->join('transports', 'transports.id', 'trips.transport_id')
            ->select(
                'trips.id',
                'transports.car_number',
                'transports.air_conditioner',
                'transports.tv_video',
                'transports.wifi',
                'transports.disabled_people_seats',
                'trips.date',
                'trips.time',
                'transports.passengers_seats',
                'transports.cubo_metres_available',
                'transports.kilos_available',
                'transports.wifi',
                'transports.tv_video',
                'transports.air_conditioner',
                'trips.type',
                'trips.status_id',
                'trips.transport_id',
                'trips.route_id'
            )
            ->find($id);

        // Filtering params
        $orderId = $request->query('order_id');     // string
        $orderType = $request->query('type');       // string
        $orderStatus = $request->query('status');   // integer: order_status_id
        $paymentStatus = $request->query('payment'); // integer: payment_status_id
        
        $drivers = DB::table('driver_trip')
            ->join('drivers', 'drivers.id', 'driver_trip.driver_id')
            ->where('driver_trip.trip_id', $trip->id)
            ->get([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone_number',
                'role',
                'photo'
            ]);
        
        $route = Route::with('route_addresses')->find($trip->route_id);
        $forwardRoutes = $route->route_addresses->where('type', 'forward');
        $backRoutes = $route->route_addresses->where('type', 'back');

        $otherForwardOrders = Order::with([ 'payment_method', 'country_from', 'country_to', 'payment_status' ])
            ->when($orderType, function($query, $orderType) {
                $query->where('order_type', $orderType);
            })
            ->when($orderId, function($query, $orderId) {
                $query->where('id', 'like', "%$orderId%");
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('order_status_id', $orderStatus);
            })
            ->whereHas('addresses', function($query) {
                $query->where('type', 'forward');
            })
            ->where('trip_id', $trip->id)
            ->get([
                'id',
                'date',
                'from_address',
                'to_address',
                'trip_id',
                'from_country',
                'to_country',
                'payment_method_id',
                'passengers_count',
                'packages_count',
                'total_price',
                'payment_status_id'
            ]);

        $otherBackOrders = Order::with([ 'payment_method', 'country_from', 'country_to', 'payment_status' ])
            ->when($orderType, function($query, $orderType) {
                $query->where('order_type', $orderType);
            })
            ->when($orderId, function($query, $orderId) {
                $query->where('id', 'like', "%$orderId%");
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('order_status_id', $orderStatus);
            })
            ->when($paymentStatus, function($query, $paymentStatus) {
                $query->where('payment_status_id', $paymentStatus);
            })
            ->whereHas('addresses', function($query) {
                $query->where('type', 'back');
            })
            ->where(function($query) use ($trip) {
                $query->where('transport_id', $trip->transport_id)
                    ->orWhere('route_id', $trip->route_id);
            })
            ->get([
                'id',
                'date',
                'from_address',
                'to_address',
                'from_country',
                'to_country',
                'payment_method_id',
                'passengers_count',
                'packages_count',
                'total_price',
                'payment_status_id'
            ]);
        
        $forwardStats = [
            'passengers' => 0,
            'packages' => 0,
            'fact_price' => 0,
            'total_price' => 0,
        ];
        foreach ($otherForwardOrders as $forwardOrder) {
            $forwardStats['passengers'] += $forwardOrder->passengers_count;
            $forwardStats['packages'] += $forwardOrder->packages_count;
            $forwardStats['total_price'] += $forwardOrder->total_price;
        }
        
        $backStats = [
            'passengers' => 0,
            'packages' => 0,
            'fact_price' => 0,
            'total_price' => 0,
        ];
        foreach ($otherBackOrders as $backOrder) {
            $backStats['passengers'] += $backOrder->passengers_count;
            $backStats['packages'] += $backOrder->packages_count;
            $backStats['total_price'] += $backOrder->total_price;
        }

        $route['forward'] = [
            'starting' => $forwardRoutes->where('order', 0)->first(),
            'ending' => $forwardRoutes->sortByDesc('order')->first(),
            'stats' => [
                'passengers' => $forwardStats['passengers'] .'/'. $trip->passengers_seats,
                'packages' => $forwardStats['packages'] .'/'. $trip->cubo_metres_available,
                'fact_price' => $forwardStats['fact_price'],
                'total_price' => $forwardStats['total_price'],
            ],
            'orders' => $otherForwardOrders
        ];

        $route['back'] = [
            'starting' => $backRoutes->where('order', 0)->where('type', 'back')->first(),
            'ending' => $backRoutes->where('type', 'back')->sortByDesc('order')->first(),
            'stats' => [
                'passengers' => $backStats['passengers'] .'/'. $trip->passengers_seats,
                'packages' => $backStats['packages'] .'/'. $trip->cubo_metres_available,
                'fact_price' => $backStats['fact_price'],
                'total_price' => $backStats['total_price'],
            ],
            'orders' => $otherBackOrders
        ];

        $route->unsetRelation('route_addresses');

        return [
            'trip' => $trip,
            'routes' => $route,
            'drivers' => $drivers,
            'car_photos' => DB::table('car_docs')->where('transport_id', $trip->transport_id)->where('doc_type', 'car_photos')->get()
        ];
    }

    /**
     * Get orders to start boarding
     * 
     * @param int $id
     */
    public function getOrdersToStartBoarding($id)
    {
        $orders = Order::with([
            'payment_status',
            'payment_method',
            'country_from',
            'country_to',
            'packages',
            'passengers' => function($query) {
                $query->select(
                    'id',
                    'first_name',
                    'last_name',
                    'birthday',
                    'passport_number',
                    'id_card'
                );
            } ])
            ->whereTripId($id)
            ->get();

        return $orders;
    }

    /**
     * Finish boarding
     * 
     * @param int $id
     */
    public function finishBoarding($id)
    {
        $trip = Trip::find($id);
        $trip->status_id = OrderStatus::getOnTheWay()->id;
        $trip->save();
        
        return [
            'success' => true,
            'trip_status' => OrderStatus::getOnTheWay()
        ];
    }
}