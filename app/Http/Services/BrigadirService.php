<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Brigadir;
use App\Driver;
use App\Expense;
use App\Http\JsonRequests\ChangeBrigadirPasswordRequest;
use App\Http\JsonRequests\InviteDriverRequest;
use App\Http\JsonRequests\UpdateBrigadirCompanyRequest;
use App\Http\JsonRequests\UpdateBrigadirRequest;
use App\Http\Traits\UploadCarDocsTrait;
use App\Jobs\InviteDriverJob;
use App\Jobs\SyncUserToMongoChatJob;
use App\Order;
use App\OrderStatus;
use App\PaymentStatus;
use App\Route;
use App\Transport;
use App\Trip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrigadirService
{
    use UploadImageTrait;
    use UploadCarDocsTrait;

    /**
     * Get all the brigadirs
     * 
     * @return collection
     */
    public function all()
    {
        return Brigadir::paginate(10);
    }

    /**
     * Get the brigadir by id.
     * 
     * @param   int $id
     * @return  collection
     */
    public function getById($id)
    {
        return Brigadir::findOrFail($id);
    }

    /**
     * Store a newly created brigadir in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  void
     */
    public function store(StoreUserRequest $request)
    {
        $brigadir = new Brigadir($request->except('password'));
        $brigadir->password = Hash::make($request->password);
        $brigadir->role = 'brigadir';
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $brigadir->save();

        SyncUserToMongoChatJob::dispatch($brigadir->toArray());
    }

    /**
     * Update a specific brigadir.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     * @return  void
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $brigadir = Brigadir::find($id);
        $brigadir->first_name = $request->first_name;
        $brigadir->last_name = $request->last_name;
        $brigadir->company_name = $request->company_name;
        $brigadir->birthday = Carbon::parse($request->birthday);
        $brigadir->nationality = $request->nationality;
        $brigadir->phone_number = $request->phone_number;
        $brigadir->email = $request->email;
        $brigadir->gender = $request->gender;
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $brigadir->save();
    }

    /**
     * Get brigadir's count
     * 
     * @return number
     */
    public function count()
    {
        return Brigadir::get()->count();
    }

    /**
     * Get brigadir's all drivers
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getDriversGroupedByTransport(Request $request)
    {
        $brigadir = auth('brigadir')->user();
        
        // Fitlering params
        $carNumber = $request->query('number');

        $driverIds = Driver::where('brigadir_id', $brigadir->id)->pluck('id');
        $transportIds = DB::table('driver_transport')->whereIn('driver_id', $driverIds)->pluck('transport_id'); 

        return Transport::with('drivers')
            ->when($carNumber, function($query, $carNumber) {
                $query->where('car_number', 'like', "%$carNumber%");
            })
            ->whereIn('id', $transportIds)
            ->get([
                'id',
                'car_number',
            ]);
    }

    /**
     * Update brigadir's profile
     * 
     * @param   \App\Http\JsonRequests\UpdateBrigadirRequest $request
     * @param   int $id
     * @return  \App\Brigadir $brigadir
     */
    public function updateProfile(UpdateBrigadirRequest $request, $id)
    {
        $brigadir = Brigadir::find($id);
        $brigadir->gender = $request->gender;
        $brigadir->first_name = $request->first_name;
        $brigadir->last_name = $request->last_name;
        $brigadir->phone_number = $request->phone_number;
        $brigadir->email = $request->email;
        $brigadir->birthday = Carbon::parse($request->birthday);
        $brigadir->nationality = $request->nationality;

        if($request->hasFile('photo')) {
            Storage::disk('public')->delete($brigadir->photo);
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $brigadir->save();

        return $brigadir;
    }

    /**
     * Update brigadir's company info
     * 
     * @param   \App\Http\JsonRequests\UpdateBrigadirCompanyRequest $request
     * @param   int $id
     * @return  \App\Brigadir $brigadir
     */
    public function updateCompany(UpdateBrigadirCompanyRequest $request, $id)
    {
        $brigadir = Brigadir::find($id);
        $brigadir->company_name = $request->company_name;
        $brigadir->inn = $request->inn;
        $brigadir->save();

        return $brigadir;
    }

    /**
     * Change password
     * 
     * @param   \App\Http\JsonRequests\ChangeBrigadirPasswordRequest $request
     * @param   int $id
     * @return  array
     */
    public function changePassword(ChangeBrigadirPasswordRequest $request)
    {
        $client = Brigadir::find(auth('brigadir')->user()->id);
        $oldPassword = $request->old_password;
        $newPassword = $request->password;
        
        if(Hash::check($oldPassword, $client->password)) {
            $client->password = Hash::make($newPassword);
            $client->save();

            return [
                'success' => true,
                'status' => 200,
                'message' => 'Password successfully updated.'
            ];
        }

        return [
            'success' => false,
            'status' => 422,
            'message' => 'The old password is wrong.'
        ];
    }

    /**
     * Invite driver
     * 
     * @param   \App\Http\JsonRequests\InviteDriverRequest $request
     * @return  void
     */
    public function inviteDriver(InviteDriverRequest $request)
    {
        $password = uniqid();

        $driver = new Driver();
        $driver->first_name = $request->name;
        $driver->phone_number = $request->phone_number;
        $driver->email = $request->email;
        $driver->password = Hash::make($password);
        $driver->brigadir_id = auth('brigadir')->user()->id;
        $driver->save();
        
        InviteDriverJob::dispatch($request->email, $password);
    }

    /**
     * Get a list of trips
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getTrips(Request $request)
    {
        // Filtering params
        $carNumber = $request->query('car_number'); // string
        $orderType = $request->query('type');       // string
        $orderStatus = $request->query('status');   // integer: order_status_id
        $from = $request->query('from');            // string
        $to = $request->query('to');                // string

        // Get the current user
        $user = auth('brigadir')->user();
        // Get all user's drivers
        $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
        // Get all user's transport by driver ids
        $transport = DB::table('driver_transport')
            ->join('transports', 'transports.id', 'driver_transport.transport_id')
            ->select('transports.*')
            ->where('transports.car_number', 'like', "%$carNumber%")
            ->whereIn('driver_id', $drivers)
            ->pluck('id');
        
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
            ->whereIn('transport_id', $transport)
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
     * Get a specific trip by id
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   int $id
     * @return  array
     */
    public function getTripById(Request $request, $id)
    {
        $stats = null;
        $totalPrice = 0;

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

        $otherForwardOrders = Order::with([ 'payment_method', 'country_from', 'country_to' ])
            ->when($orderType, function($query, $orderType) {
                $query->where('order_type', $orderType);
            })
            ->when($orderId, function($query, $orderId) {
                $query->where('id', 'like', "%$orderId%");
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('order_status_id', $orderStatus);
            })
            ->whereHas('addresses', function(Builder $query) {
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

        $otherBackOrders = Order::with([ 'payment_method' ])
            ->when($orderType, function($query, $orderType) {
                $query->where('order_type', $orderType);
            })
            ->when($orderId, function($query, $orderId) {
                $query->where('id', 'like', "%$orderId%");
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('order_status_id', $orderStatus);
            })
            ->whereHas('addresses', function(Builder $query) {
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
        
        $expenses = Expense::with('photos')->whereTripId($trip->id)->get();
        
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
            if($forwardOrder->payment_status_id === PaymentStatus::getPaid()->id) {
                $forwardStats['fact_price'] += $forwardOrder->sum('total_price');
            }
        }

        $forwardStats['fact_price'] = $forwardStats['fact_price'] - $expenses->where('type', 'forward')->sum('amount');
        
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
            if($backOrder->payment_status_id === PaymentStatus::getPaid()->id) {
                $backStats['fact_price'] += $backOrder->sum('total_price');
            }
        }

        $backStats['fact_price'] = $backStats['fact_price'] - $expenses->where('type', 'back')->sum('amount');

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

        $totalPrice = $forwardStats['total_price'] + $backStats['total_price'];

        $stats = [
            'totalPrice' => $totalPrice,
            'expenses' => $expenses,
            'factPrice' => Order::whereTripId($trip->id)->wherePaymentStatusId(PaymentStatus::getPaid()->id)->sum('total_price') - $expenses->sum('amount')
        ];

        return [
            'trip' => $trip,
            'routes' => $route,
            'drivers' => $drivers,
            'car_photos' => DB::table('car_docs')->where('transport_id', $trip->transport_id)->where('doc_type', 'car_photos')->get(),
            'stats' => $stats
        ];
    }

    /**
     * Get a list of finished trips
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  array
     */
    public function getFinishedTrips(Request $request)
    {
        // Filtering params
        $carNumber = $request->query('car_number'); // string
        $orderType = $request->query('type');       // string
        $orderStatus = $request->query('status');   // integer: order_status_id
        $from = $request->query('from');            // string
        $to = $request->query('to');                // string

        // Get the current user
        $user = $request->authUser;
        // Get all user's drivers
        $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
        // Get all user's transport by driver ids
        $transport = DB::table('driver_transport')
            ->join('transports', 'transports.id', 'driver_transport.transport_id')
            ->select('transports.*')
            ->where('transports.car_number', 'like', "%$carNumber%")
            ->whereIn('driver_id', $drivers)
            ->pluck('id');
        
        // Get trips by transport id
        $trips = Trip::with([ 'from_country', 'to_country', 'status', 'orders' ])
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
            ->whereIn('transport_id', $transport)
            ->where(function($query) {
                // $query->where('status_id', OrderStatus::getFinished()->id)
                //     ->orWhere('status_id', OrderStatus::getCancelled()->id);
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

        $weeks = [];
        if($trips->count() > 0) {
            $firstOrder = Order::where('trip_id', $trips->pluck('id'))->orderBy('id')->first();
    
            
            if($firstOrder) {
                $now = Carbon::parse($firstOrder->date);
                $endOfMonth = Carbon::parse($firstOrder->date)->endOfMonth();
    
                do {
                    $endOfWeek = Carbon::parse($now)->addDays(7);
                    $formattedNow = $now->format('d.m.Y');
                    $formattedEndOfWeek = $endOfWeek->format('d.m.Y');
        
                    if(Carbon::parse($now)->addDays(8) >= $endOfMonth) {
                        $datesArray = [$now, $endOfMonth];
                    } else {
                        $datesArray = [$now, $endOfWeek];
                    }
        
                    $filteredTrips = $trips->whereBetween('date', $datesArray);
                    $tripTransactions = Order::leftJoin('transactions', 'transactions.order_id', 'orders.id')
                        ->whereIn('orders.trip_id', $filteredTrips->pluck('id'))
                        ->whereBetween('orders.date', $datesArray)
                        ->get();

                    $totalProfit = $tripTransactions->where('type', 'income')->sum('amount');
                    $serviceComission = $tripTransactions->where('type', 'outcome')->sum('amount');
                    $debts = $tripTransactions->where('payment_status_id', PaymentStatus::getNotPaid()->id)->sum('total_price');
                    $expenses = 0;
    
                    foreach ($filteredTrips as $item) {
                        $expenses = Expense::where('trip_id', $item->trip_id)->sum('amount');
                    }
        
                    $weeks[] = [
                        'from' => $formattedNow,
                        'to' => $formattedEndOfWeek,
                        'total_profit' => $totalProfit,
                        'service_comission' => $serviceComission,
                        'debts' => $debts,
                        'expenses' => $expenses,
                        'clean_profit' => $totalProfit - $serviceComission - $expenses,
                        'trips' => $filteredTrips,
                    ];
        
                    // Move the next week
                    $now->addDays(8);
                } while ($now <= $endOfMonth);
            }
        }
        
        return $weeks;
    }

    /**
     * Get all available transport
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getTransport(Request $request)
    {
        $queryString = $request->query('q');
        // Get the current user
        $user = auth('brigadir')->user();
        // Get all user's drivers
        $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
        // Get all user's transport
        $transport = Transport::with([ 'car_docs', 'drivers' ])
            ->whereHas('drivers', function(Builder $query) use ($drivers) {
                $query->whereIn('id', $drivers);
            })
            ->where('car_number', 'like', "%$queryString%")
            ->get([
                'id',
                'car_number',
                'wifi',
                'air_conditioner',
                'tv_video',
                'disabled_people_seats'
            ]);

        return $transport;
    }
    
    /**
     * Get all available transport (only car_number)
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getTransportWithOnlyCarNumber(Request $request)
    {
        $queryString = $request->query('q');
        // Get the current user
        $user = auth('brigadir')->user();
        // Get all user's drivers
        $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
        // Get all user's transport
        $transport = Transport::
            whereHas('drivers', function(Builder $query) use ($drivers) {
                $query->whereIn('id', $drivers);
            })
            ->where('car_number', 'like', "%$queryString%")
            ->get([ 
                'id',
                'car_number'
            ]);

        return $transport;
    }

    /**
     * Block access to the driver
     * 
     * @param   int $id
     * @return  void
     */
    public function blockDriver($id)
    {
        Driver::where('id', $id)->update([
            'blocked' => 1
        ]);
    }

    /**
     * Detach driver from order
     * 
     * @param   int $id
     * @param   int $orderId
     * @return  void
     */
    public function detachDriverFromOrder($id, $orderId)
    {
        DB::table('driver_order')
            ->where([
                'driver_id' => $id,
                'order_id' => $orderId
            ])
            ->delete();
    }

    /**
     * Get drivers
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getDrivers(Request $request)
    {
        $user = auth('brigadir')->user();

        $name = $request->query('name');
        return Driver::when($name, function($query, $name) {
            $query->where('first_name', 'like', "%$name%")
                ->orWhere('last_name', 'like', "%$name%");
        })
        ->whereBrigadirId($user->id)
        ->get();
    }

    /**
     * Attach driver to the order
     * 
     * @param   int $id
     * @param   int $orderId
     * @return  void
     */
    public function attachDriverToOrder($id, $orderId)
    {
        DB::table('driver_order')->insert([
            'driver_id' => $id,
            'order_id' => $orderId
        ]);
    }

    /**
     * Get driver by id
     * 
     * @param   int $id
     * @return  collection
     */
    public function getDriverById($id)
    {
        $driver = Driver::leftJoin('driver_transport', 'driver_transport.driver_id', 'drivers.id')
            ->join('transports', 'driver_transport.transport_id', 'transports.id')
            ->select('drivers.*', 'transports.car_number', 'transports.id as transport_id')
            ->where('drivers.id', $id)
            ->first();

        $trips = DB::table('driver_trip')
            ->join('trips', 'trips.id', 'driver_trip.trip_id')
            ->select('trips.*')
            ->where('driver_id', $driver->id)
            ->get();
            
        $driver['future_trips'] = $trips->where('status_id', OrderStatus::getFuture()->id)->count();
        $driver['finished_trips'] = $trips->where('status_id', OrderStatus::getFinished()->id)->count();

        return $driver;
    }

    /**
     * Get driver's transport
     * 
     * @param   int $id
     * @return  collection
     */
    public function getDriversTransport($id)
    {
        return DB::table('driver_transport')
            ->join('transports', 'transports.id', 'driver_transport.transport_id')
            ->select('transports.*')
            ->whereDriverId($id)
            ->first();
    }

    /**
     * Get driver's trips
     */
    public function getDriversTrips(Request $request, $id)
    {
        // Filtering params
        $orderStatus = $request->query('status');   // integer: order_status_id
        $from = $request->query('from');            // string
        $to = $request->query('to');                // string

        // Get the current user
        $user = $request->authUser;
        // Get all user's transport by driver ids
        $transport = DB::table('driver_transport')->whereDriverId($id)->pluck('transport_id');
        
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
            ->whereIn('transport_id', $transport)
            ->get();

        $weeks = [];
        if($trips->count() > 0) {
            $firstOrder = Order::where('trip_id', $trips->pluck('id'))->orderBy('id')->first();
            
            if($firstOrder) {
                $now = Carbon::parse($firstOrder->date);
                $endOfMonth = Carbon::parse($firstOrder->date)->endOfMonth();
    
                do {
                    $endOfWeek = Carbon::parse($now)->addDays(7);
                    $formattedNow = $now->format('d.m.Y');
                    $formattedEndOfWeek = $endOfWeek->format('d.m.Y');
        
                    if(Carbon::parse($now)->addDays(8) >= $endOfMonth) {
                        $datesArray = [$now, $endOfMonth];
                    } else {
                        $datesArray = [$now, $endOfWeek];
                    }
        
                    $filteredTrips = $trips->whereBetween('date', $datesArray);
                    $tripTransactions = Order::leftJoin('transactions', 'transactions.order_id', 'orders.id')
                        ->whereIn('orders.trip_id', $filteredTrips->pluck('id'))
                        ->whereBetween('orders.date', $datesArray)
                        ->get();

                    $totalProfit = $tripTransactions->where('type', 'income')->sum('amount');
                    $serviceComission = $tripTransactions->where('type', 'outcome')->sum('amount');
                    $debts = $tripTransactions->where('payment_status_id', PaymentStatus::getNotPaid()->id)->sum('total_price');
                    $expenses = 0;
    
                    foreach ($filteredTrips as $item) {
                        $expenses = Expense::where('trip_id', $item->trip_id)->sum('amount');
                    }
        
                    if($filteredTrips->count() > 0) {
                        $weeks[] = [
                            'from' => $formattedNow,
                            'to' => $formattedEndOfWeek,
                            'total_profit' => $totalProfit,
                            'service_comission' => $serviceComission,
                            'debts' => $debts,
                            'expenses' => $expenses,
                            'clean_profit' => $totalProfit - $serviceComission - $expenses,
                            'trips' => $filteredTrips,
                        ];
                    }
        
                    // Move the next week
                    $now->addDays(8);
                } while ($now <= $endOfMonth);
            }
        }
        
        return $weeks;
    }

    /**
     * Change driver's password
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function changeDriversPassword(Request $request, $id)
    {
        $driver = Driver::find($id);
        $driver->password = Hash::make($request->password);
        $driver->save();
    }

    /**
     * Get routes
     * 
     * @param \Illuminate\Http\Request $request
     * @return collection
     */
    public function getRoutes(Request $request)
    {
        $q = $request->query('q');
        // Get the current user
        $user = auth('brigadir')->user();
        // Get all user's drivers
        $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
        // Get all user's transport
        $transport = Transport::with([ 'car_docs', 'drivers' ])
            ->whereHas('drivers', function(Builder $query) use ($drivers) {
                $query->whereIn('id', $drivers);
            })
            ->pluck('id');
        
        $routes = Route::with('route_addresses')
            ->join('transports', 'transports.id', 'routes.transport_id')
            ->select(
                'transports.car_number',
                'routes.*'
            )
            ->where('status', 'active')
            ->whereIn('transport_id', $transport)
            ->get();

        foreach ($routes as $route) {
            $route['forward'] = $route->getStartingCountryWithTime();
            $route['back'] = $route->getEndingCountryWithTime();
            $route['drivers'] = DB::table('driver_transport')
                ->join('drivers', 'drivers.id', 'driver_transport.driver_id')
                ->where('transport_id', $route->transport_id)
                ->select('drivers.first_name', 'drivers.last_name', 'drivers.photo')
                ->get();
        }
        
        return $routes;
    }
    
    /**
     * Get archived routes
     * 
     * @param \Illuminate\Http\Request $request
     * @return collection
     */
    public function getArchivedRoutes(Request $request)
    {
        $q = $request->query('q');
        // Get the current user
        $user = auth('brigadir')->user();
        // Get all user's drivers
        $drivers = Driver::whereBrigadirId($user->id)->pluck('id');
        // Get all user's transport
        $transport = Transport::with([ 'car_docs', 'drivers' ])
            ->whereHas('drivers', function(Builder $query) use ($drivers) {
                $query->whereIn('id', $drivers);
            })
            ->pluck('id');
        
        $routes = Route::with('route_addresses')
            ->join('transports', 'transports.id', 'routes.transport_id')
            ->select(
                'transports.car_number',
                'routes.*'
            )
            ->where('status', 'archive')
            ->whereIn('transport_id', $transport)
            ->get();

        foreach ($routes as $route) {
            $route['forward'] = $route->getStartingCountryWithTime();
            $route['back'] = $route->getEndingCountryWithTime();
            $route['drivers'] = DB::table('driver_transport')
                ->join('drivers', 'drivers.id', 'driver_transport.driver_id')
                ->where('transport_id', $route->transport_id)
                ->select('drivers.first_name', 'drivers.last_name', 'drivers.photo')
                ->get();
        }
        
        return $routes;
    }

    /**
     * Work as driver
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $asDriver
     */
    public function workAsDriver(Request $request)
    {
        DB::table('brigadirs')
            ->where('id', $request->authUser->id)
            ->update([ 'as_driver' => $request->as_driver ]);
    }

    /**
     * Save driver's data
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  Driver $driver
     */
    public function saveDriverData(Request $request)
    {
        $driver = Driver::whereAsDriverId($request->authUser->id)->first();

        if(!$driver) {
            $driver = new Driver();
        }

        $driver->country_id = $request->country_id;
        $driver->city = $request->city;
        $driver->comment = $request->comment;
        $driver->dl_issue_place = $request->dl_issue_place;
        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->driving_experience_id = $request->driving_experience_id;
        $driver->conviction = isset($request->conviction) ? 1 : 0;
        $driver->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driver->dtp = isset($request->dtp) ? 1 : 0;
        $driver->grades = $request->grades;
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);
        $driver->as_driver_id = $request->authUser->id;

        // Upload driver's documents
        $passportDocs = [];
        $dLicenseDocs = [];

        if($request->hasFile('passport_photos')) {
            $passportDocs = UploadFileService::uploadMultiple($request->passport_photos, 'driver_docs');
        }

        if($request->hasFile('driving_license_photos')) {
            $dLicenseDocs = UploadFileService::uploadMultiple($request->driving_license_photos, 'driver_docs');
        }

        if($driver->driving_license_photos !== null) {
            $driver->driving_license_photos = array_merge($driver->driving_license_photos, $dLicenseDocs);
        } else {
            $driver->driving_license_photos = $dLicenseDocs ? $dLicenseDocs : null;
        }

        if($driver->passport_photos !== null) {
            $driver->passport_photos = array_merge($driver->passport_photos, $dLicenseDocs);
        } else {
            $driver->passport_photos = $passportDocs ? $passportDocs : null;
        }

        $driver->save();

        return $driver;
    }

    /**
     * Save as driver transport data
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function saveTransportData(Request $request)
    {
        $transport = Transport::whereBrigadirId($request->authUser->id)->first();
        
        if(!$transport) {
            $transport = new Transport();
        }

        $transport->registered_on = $request->registered_on;
        $transport->register_country = $request->register_country;
        $transport->register_city = $request->register_city;
        $transport->car_number = $request->car_number;
        $transport->car_brand_id = $request->car_brand_id;
        $transport->car_model_id = $request->car_model_id;
        $transport->year = $request->year;
         // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($request->teh_osmotr_date_from);
        $transport->teh_osmotr_date_to = Carbon::parse($request->teh_osmotr_date_to);
        $transport->insurance_date_from = Carbon::parse($request->insurance_date_from);
        $transport->insurance_date_to = Carbon::parse($request->insurance_date_to);
        // *** 
        $transport->has_cmr = $request->has_cmr;
        $transport->passengers_seats = $request->passengers_seats; 
        $transport->cubo_metres_available = $request->cubo_metres_available; 
        $transport->kilos_available = $request->kilos_available; 
        $transport->ok_for_move = $request->ok_for_move; 
        $transport->can_pull_trailer = $request->can_pull_trailer; 
        $transport->has_trailer = $request->has_trailer; 
        $transport->pallet_transportation = $request->pallet_transportation; 
        $transport->air_conditioner = $request->air_conditioner; 
        $transport->wifi = $request->wifi; 
        $transport->tv_video = $request->tv_video; 
        $transport->disabled_people_seats = $request->disabled_people_seats;
        $transport->brigadir_id = $request->authUser->id;
        
        $transport->save();

        // Docs
        $this->storeCarDocs($transport, $request);

        return $transport;
    }

    /**
     * Store transport's doc files
     * @param
     */
    private function storeCarDocs(Transport $transport, $request)
    {
        $docs = [];
        if(isset($request->car_passport)) {
            $docs = array_merge($docs, $this->uploadDocs($request->car_passport, 'car_docs/passport', Transport::DOC_TYPE_PASSPORT));
        }
        
        if(isset($request->teh_osmotr)) {
            $docs = array_merge($docs, $this->uploadDocs($request->teh_osmotr, 'car_docs/teh_osmotr', Transport::DOC_TYPE_TEH_OSMOTR));
        }

        if(isset($request->insurance)) {
            $docs = array_merge($docs, $this->uploadDocs($request->insurance, 'car_docs/insurance', Transport::DOC_TYPE_INSURANCE));
        }

        if(isset($request->people_license)) {
            $docs = array_merge($docs, $this->uploadDocs($request->people_license, 'car_docs/people_license', Transport::DOC_TYPE_PEOPLE_LICENSE));
        }

        if(isset($request->car_photos)) {
            $docs = array_merge($docs, $this->uploadDocs($request->car_photos, 'car_docs/car_photos', Transport::DOC_TYPE_CAR_PHOTOS));
        }

        if(isset($request->trailer_photos)) {
            $docs = array_merge($docs, $this->uploadDocs($request->trailer_photos, 'car_docs/trailer_photos', Transport::DOC_TYPE_TRAILER_PHOTOS));
        }

        $transport->car_docs()->saveMany($docs);
    }
}