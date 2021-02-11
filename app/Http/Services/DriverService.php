<?php

namespace App\Http\Services;

use App\Http\Services\UploadFileService;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Traits\UploadImageTrait;
use App\Http\Traits\UploadDocsTrait;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Driver;
use App\Expense;
use App\Http\JsonRequests\ChangePasswordRequest;
use App\Http\JsonRequests\UpdateDriverRequest;
use App\Jobs\SyncUserToMongoChatJob;
use App\Order;
use App\PaymentStatus;
use App\Route;
use App\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverService
{
    use UploadImageTrait, UploadDocsTrait;

    /**
     * Get all the drivers
     * 
     * @return collection
     */
    public function all()
    {
        // return User::with([
        //     'driver_data' => function($query) {
        //         $query->with([ 'country', 'driving_experience' ])
        //             ->join('countries as cc', 'cc.id', '=', 'driver_data.dl_issue_place')
        //             ->select('cc.name as dl_issue_place_name', 'driver_data.*');
        //     }
        // ])->where('role', User::ROLE_DRIVER)->paginate(10);

        return Driver::with([ 'country', 'driving_experience' ])->paginate(10);
    }

    /**
     * Get the driver by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return Driver::findOrFail($id);
    }

    /**
     * Store a newly created driver in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function storeNew($data)
    {
        $driver = new Driver();
        $driver->first_name = $data['first_name'];
        $driver->last_name = $data['last_name'];
        $driver->gender = 1;
        $driver->nationality = $data['nationality'];
        $driver->city = $data['city'];
        $driver->comment = $data['comment'];
        $driver->phone_number = $data['phone_number'];
        $driver->email = $data['email'];
        $driver->birthday = $data['birthday'];
        $driver->country_id = $data['country_id'];
        $driver->dl_issue_place = $data['dl_issue_place'];
        $driver->driving_experience_id = $data['driving_experience_id'];
        $driver->dl_issued_at = Carbon::parse($data['dl_issued_at']);
        $driver->dl_expires_at = Carbon::parse($data['dl_expires_at']);
        $driver->driving_experience_id = $data['driving_experience_id'];
        $driver->conviction = isset($data['conviction']) ? 1 : 0;
        $driver->was_kept_drunk = isset($data['was_kept_drunk']) ? 1 : 0;
        $driver->dtp = isset($data['dtp']) ? 1 : 0;
        $driver->grades = $data['grades'];
        $driver->grades_expire_at = Carbon::parse($data['grades_expire_at']);
        $driver->password = Hash::make($data['password']);
        $driver->driving_license_photos = $data['driving_license_photos'];
        $driver->role = 'head_driver';
        $driver->save();

        if(isset($data['photo']) && $data['photo']) {
            $driver->photo = $this->uploadImage($data['photo'], 'user_photos');
        }
        
        if(isset($data['driving_license_photos']) && $data['driving_license_photos']) {
            $driver->driving_license_photos = UploadFileService::uploadMultiple($data['driving_license_photos'], 'driver_docs');
        }
        
        if(isset($data['passport_photos']) && $data['passport_photos']) {
            $driver->passport_photos = UploadFileService::uploadMultiple($data['passport_photos'], 'driver_docs');
        }

        return $driver;
    }

    /**
     * Store a newly created driver in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $driver = new Driver($request->except('password'));
        $driver->password = Hash::make($request->password);

        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->conviction = isset($request->conviction) ? 1 : 0;
        $driver->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driver->dtp = isset($request->dtp) ? 1 : 0;
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);
        $driver->role = 'driver';
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        if($request->hasFile('driving_license_photos')) {
            $driver->driving_license_photos = UploadFileService::uploadMultiple($request->driving_license_photos, 'driver_docs');
        }
        
        if($request->hasFile('passport_photos')) {
            $driver->passport_photos = UploadFileService::uploadMultiple($request->passport_photos, 'driver_docs');
        }
        
        $driver->save();

        SyncUserToMongoChatJob::dispatch($driver->toArray());
    }

    /**
     * Update a specific driver.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $driver = Driver::find($id);
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->city = $request->city;
        $driver->comment = $request->comment;
        $driver->birthday = Carbon::parse($request->birthday);
        $driver->nationality = $request->nationality;
        $driver->phone_number = $request->phone_number;
        $driver->email = $request->email;
        $driver->gender = $request->gender;
        $driver->dl_issue_place = $request->dl_issue_place;
        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->driving_experience_id = $request->driving_experience_id;
        $driver->conviction = isset($request->conviction) ? 1 : 0;
        $driver->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driver->dtp = isset($request->dtp) ? 1 : 0;
        $driver->grades = $request->grades;
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);
        
        if($request->hasFile('photo')) {
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }

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
    }

    /**
     * Get driver's count
     */
    public function count()
    {
        return Driver::get()->count();
    }

    /**
     * Delete driver's document
     * 
     * @param   int $driverId
     * @param   int $docId
     */
    public function destroyDoc($driverId, $docId)
    {
        $driver = Driver::findOrFail($driverId);

        // Update the db
        $filteredDocs = [];
        foreach ($driver->docs as $doc) {
            if($doc->id !== $docId) {
                $filteredDocs[] = $doc;
            } else {
                // Delete the file from the storage
                Storage::disk('public')->delete($doc->file);
            }
        }

        $driver->docs = count($filteredDocs) > 0 ? $filteredDocs : null;
        $driver->save();

        return $filteredDocs;
    }

    /**
     * Change password
     * 
     * @param \App\Http\JsonRequests\ChangePasswordRequest $request
     * @param int $id
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $driver = Driver::find(auth('driver')->user()->id);
        $oldPassword = $request->old_password;
        $newPassword = $request->password;

        if(Hash::check($oldPassword, $driver->password)) {
            $driver->password = Hash::make($newPassword);
            $driver->save();

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
     * Update a specific driver.
     * 
     * @param   \App\Http\JsonRequests\UpdateDriverRequest $request
     * @param   int $id
     */
    public function updateProfile(UpdateDriverRequest $request, $id)
    {
        $driver = Driver::find($id);
        $driver->first_name = $request->first_name;
        $driver->last_name = $request->last_name;
        $driver->city = $request->city;
        $driver->comment = $request->comment;
        $driver->birthday = Carbon::parse($request->birthday);
        $driver->nationality = $request->nationality;
        $driver->phone_number = $request->phone_number;
        $driver->email = $request->email;
        $driver->gender = $request->gender;
        $driver->country_id = $request->country_id;
        $driver->dl_issue_place = $request->dl_issue_place;
        $driver->dl_issued_at = Carbon::parse($request->dl_issued_at);
        $driver->dl_expires_at = Carbon::parse($request->dl_expires_at);
        $driver->driving_experience_id = $request->driving_experience_id;
        $driver->conviction = isset($request->conviction) ? 1 : 0;
        $driver->was_kept_drunk = isset($request->was_kept_drunk) ? 1 : 0;
        $driver->dtp = isset($request->dtp) ? 1 : 0;
        $driver->grades = $request->grades;
        $driver->grades_expire_at = Carbon::parse($request->grades_expire_at);
        
        if($request->hasFile('photo')) {
            Storage::disk('public')->delete($driver->photo);
            $driver->photo = $this->uploadImage($request->photo, 'user_photos');
        }

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
     * Get a list of orders
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  collection
     */
    public function getTrips(Request $request)
    {
        $user = $request->authUser;
        // Filtering params
        $orderType = $request->query('type');       // string
        $orderStatus = $request->query('status');   // integer: order_status_id
        $from = $request->query('from');            // string
        $to = $request->query('to');                // string

        $transport = DB::table('driver_transport')->whereDriverId($user->id)->pluck('transport_id');

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
        // Get all user's transport by driver ids
        $transport = DB::table('driver_transport')->whereDriverId($user->id)->pluck('transport_id');
        
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
     * Get driver's routes
     * 
     * @param \Illuminate\Http\Request
     * @return collection
     */
    public function getRoutes(Request $request)
    {
        // Filtering params
        $q = $request->query('q');

        $driver = auth('driver')->user();
        // Get driver's transport
        $transport = DB::table('driver_transport')->where('driver_id', $driver->id)->pluck('transport_id');
        // Get all routes
        $routes = Route::with('route_addresses')
            ->where('status', 'active')
            ->whereIn('transport_id', $transport)
            ->get();

        foreach ($routes as $route) {
            $route['starting'] = $route->getStartingCountryWithTime();
            $route['ending'] = $route->getEndingCountryWithTime();
        }

        return $routes;
    }
    
    /**
     * Get driver's archived routes
     * 
     * @param \Illuminate\Http\Request
     * @return collection
     */
    public function getArchivedRoutes(Request $request)
    {
        // Filtering params
        $q = $request->query('q');

        $driver = auth('driver')->user();
        // Get driver's transport
        $transport = DB::table('driver_transport')->where('driver_id', $driver->id)->pluck('transport_id');
        // Get all routes
        $routes = Route::with('route_addresses')
            ->where('status', 'archive')
            ->whereIn('transport_id', $transport)
            ->get();

        foreach ($routes as $route) {
            $route['starting'] = $route->getStartingCountryWithTime();
            $route['ending'] = $route->getEndingCountryWithTime();
        }

        return $routes;
    }
}