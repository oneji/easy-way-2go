<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\JsonRequests\ChangePasswordRequest;
use App\Http\JsonRequests\UpdateClientRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\Client;
use App\Http\JsonRequests\CheckEmailRequest;
use App\Jobs\RegisterJob;
use App\Jobs\SyncUserToMongoChatJob;
use App\Http\Services\SmsSendService;
use App\Order;
use Illuminate\Http\Request;

class ClientService
{
    use UploadImageTrait;
    protected $smsSendService;

    /**
     * UserAuthService constructor
     * 
     * @param \App\Http\Services\SmsSendService $smsSendService
     */
    public function __construct(SmsSendService $smsSendService)
    {
        $this->smsSendService = $smsSendService;
    }

    /**
     * Get all the clie$clients
     * 
     * @return collection
     */
    public function all()
    {
        return Client::paginate(10);
    }

    /**
     * Get the client by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return Client::findOrFail($id);
    }

    /** 
     * Store a newly created user in the db.
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  array
     */
    public function register(Request $request)
    {
        $client = new Client($request->except('password'));
        $client->verification_code = mt_rand(100000, 999999);
        $client->password = Hash::make($request->password);
        $client->role = 'client';
        
        if($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }
        
        $client->save();
        $this->smsSendService->sendSms($client->phone_number, $client->verification_code);
       SyncUserToMongoChatJob::dispatch($client->toArray());
       // RegisterJob::dispatch($client->email, $client->verification_code);   

        // TODO: Connect sms endpoint and the verification code via sms.
        return [ 
            'success' => true,
            'verification_code' => $client->verification_code,
            'data' => $client
        ];
    }

    /**
     * Store a newly created client in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $client = new Client($request->except('password'));
        $client->verified = 1;
        $client->birthday = Carbon::parse($request->birthday);
        $client->phone_number_verified_at = Carbon::now();
        $client->password = Hash::make($request->password);
        $client->id_card_expires_at = Carbon::parse($request->id_card_expires_at);
        $client->passport_expires_at = Carbon::parse($request->passport_expires_at);
        $client->role = 'client';

        if($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $client->save();

        SyncUserToMongoChatJob::dispatch($client->toArray());
    }

    /**
     * Update a specific client.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $client = Client::find($id);
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->birthday = Carbon::parse($request->birthday);
        $client->nationality = $request->nationality;
        $client->phone_number = $request->phone_number;
        $client->email = $request->email;
        $client->gender = $request->gender;
        $client->id_card = $request->id_card;
        $client->id_card_expires_at = Carbon::parse($request->id_card_expires_at);
        $client->passport_number = $request->passport_number;
        $client->passport_expires_at = Carbon::parse($request->passport_expires_at);
        
        if($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $client->save();
    }

    /**
     * Get client's count
     */
    public function count()
    {
        return Client::get()->count();
    }

    /**
     * Update a specific client.
     * 
     * @param   \App\Http\JsonRequests\UpdateClientRequest $request
     * @param   int $id
     */
    public function updateProfile(UpdateClientRequest $request, $id)
    {
        $client = Client::find($id);
        $client->first_name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->birthday = Carbon::parse($request->birthday);
        $client->nationality = $request->nationality;
        $client->phone_number = $request->phone_number;
        $client->email = $request->email;
        $client->gender = $request->gender;
        $client->id_card = $request->id_card;
        $client->id_card_expires_at = Carbon::parse($request->id_card_expires_at);
        $client->passport_number = $request->passport_number;
        $client->passport_expires_at = Carbon::parse($request->passport_expires_at);
        
        if($request->hasFile('photo')) {
            Storage::disk('public')->delete($client->photo);
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $client->save();

        return $client;
    }

    /**
     * Change password
     * 
     * @param \App\Http\JsonRequests\ChangePasswordRequest $request
     * @param int $id
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $client = Client::find(auth('client')->user()->id);
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
     * Check client's email address
     * 
     * @param \App\Http\JsonRequests\CheckEmailRequest $request
     */
    public function checkEmail(CheckEmailRequest $request)
    {
        $client = Client::where('email', $request->email)->exists();
        $success = false;

        if($client) {
            $success = true;
        }
        
        return [
            'success' => $success,
            'email' => $request->email
        ];
    }

    /**
     * Get all client's orders
     * 
     * @param \Illuminate\Http\Request $request
     * @return collection
     */
    public function getOrders(Request $request)
    {
        $client = $request->authUser;
        // Filtering params
        $id = $request->query('id');
        $type = $request->query('type');
        $from = $request->query('from');
        $to = $request->query('to');
        $limit = $request->query('limit') ? $request->query('limit') : 10;

        return Order::with([ 'country_from', 'country_to', 'status' ])
            ->join('transports', 'transports.id', 'orders.transport_id')
            ->join('trips', 'trips.id', 'orders.trip_id')
            ->select(
                'orders.id',
                'orders.from_country',
                'orders.from_address',
                'orders.to_country',
                'orders.to_address',
                'orders.total_price',
                'orders.transport_id',
                'orders.order_type',
                'orders.date',
                'transports.car_number',
                'orders.order_status_id'
            )
            ->when($id, function($query, $id) {
                $query->where('id', 'like', "%$id%");
            })
            ->when($type, function($query, $type) {
                $query->where('order_type', $type);
            })
            ->when($from, function($query, $from) {
                $query->where('date', '>=', Carbon::parse($from));
            })
            ->when($to, function($query, $to) {
                $query->where('date', '<=', Carbon::parse($to));
            })
            ->where('client_id', $client->id)
            ->paginate($limit);
    }
}