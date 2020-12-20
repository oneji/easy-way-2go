<?php

namespace App\Http\Services;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Brigadir;
use App\Driver;
use App\Http\JsonRequests\ChangeBrigadirPasswordRequest;
use App\Http\JsonRequests\InviteDriverRequest;
use App\Http\JsonRequests\UpdateBrigadirCompanyRequest;
use App\Http\JsonRequests\UpdateBrigadirRequest;
use App\Jobs\InviteDriverJob;
use App\Order;
use App\Transport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrigadirService
{
    use UploadImageTrait;

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
     */
    public function getById($id)
    {
        return Brigadir::findOrFail($id);
    }

    /**
     * Store a newly created brigadir in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $brigadir = new Brigadir($request->except('password'));
        $brigadir->password = Hash::make($request->password);
        
        if($request->hasFile('photo')) {
            $brigadir->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $brigadir->save();
    }

    /**
     * Update a specific brigadir.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
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
     * @return collection
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
    public function getDrivers(Request $request)
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
            ->get();
    }

    /**
     * Update brigadir's profile
     * 
     * @param \App\Http\JsonRequests\UpdateBrigadirRequest $request
     * @param int $id
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
     * @param \App\Http\JsonRequests\UpdateBrigadirCompanyRequest $request
     * @param int $id
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
     * @param \App\Http\JsonRequests\ChangeBrigadirPasswordRequest $request
     * @param int $id
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
     * @param \App\Http\JsonRequests\InviteDriverRequest $request
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
     * Get a list of orders
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getOrders(Request $request)
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
        
        // Get order by transport ids
        $orders = Order::with([ 'country_from', 'country_to' ])
            ->leftJoin('transports', 'transports.id', 'orders.transport_id')
            ->select(
                'orders.id',
                'transports.car_number',
                'orders.date',
                'orders.from_address',
                'orders.to_address',
                'transports.passengers_seats',
                'transports.cubo_metres_available',
                'transports.kilos_available',
                'orders.passengers_count',
                'orders.packages_count',
                'orders.total_price',
                'orders.order_type',
                'orders.order_status_id',
                'orders.from_country',
                'orders.to_country'
            )
            ->when($orderType, function($query, $orderType) {
                $query->where('order_type', $orderType);
            })
            ->when($from, function($query, $from) {
                $query->where('date', '>=', Carbon::parse($from));
            })
            ->when($to, function($query, $to) {
                $query->where('date', '<=', Carbon::parse($to));
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('order_status_id', $orderStatus);
            })
            ->whereIn('transport_id', $transport)
            ->get();

        return $orders;
    }

    /**
     * Get a specific order by id
     * 
     * @param int $id
     */
    public function getOrderById(Request $request, $id)
    {
        $order = Order::with([ 'country_from', 'country_to' ])
            ->join('transports', 'transports.id', 'orders.transport_id')
            ->select(
                'orders.id',
                'transports.car_number',
                'orders.date',
                'orders.from_address',
                'orders.to_address',
                'transports.passengers_seats',
                'transports.cubo_metres_available',
                'transports.kilos_available',
                'orders.passengers_count',
                'orders.packages_count',
                'orders.total_price',
                'orders.order_type',
                'orders.order_status_id',
                'orders.from_country',
                'orders.to_country',
                'orders.transport_id'
            )
            ->find($id);

        // Filtering params
        $orderId = $request->query('id'); // string
        $orderType = $request->query('type');       // string
        $orderStatus = $request->query('status');   // integer: order_status_id
        
        $otherOrders = Order::with('payment_method')
            ->when($orderType, function($query, $orderType) {
                $query->where('order_type', $orderType);
            })
            ->when($orderId, function($query, $orderId) {
                $query->where('id', 'like', "%$orderId%");
            })
            ->when($orderStatus, function($query, $orderStatus) {
                $query->where('order_status_id', $orderStatus);
            })
            ->whereTransportId($order->transport_id)
            ->where('id', '<>', $order->id)
            ->get();
        
        $drivers = DB::table('driver_transport')
            ->join('drivers', 'drivers.id', 'driver_transport.driver_id')
            ->select('drivers.*')
            ->where('driver_transport.transport_id', $order->transport_id)
            ->get();

        return [
            'order' => $order,
            'otherOrders' => $otherOrders,
            'drivers' => $drivers
        ];
    }

    /**
     * Get all available transport
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
            ->whereHas('drivers', function(Builder $query) use ($drivers, $queryString) {
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
}