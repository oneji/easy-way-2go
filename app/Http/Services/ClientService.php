<?php

namespace App\Http\Services;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\UploadImageTrait;
use Carbon\Carbon;
use App\ClientData;
use App\User;

class ClientService
{
    use UploadImageTrait;

    /**
     * Get all the clie$clients
     * 
     * @return collection
     */
    public function all()
    {
        return User::with('client_data')->where('role', User::ROLE_CLIENT)->paginate(10);
    }

    /**
     * Get the client by id.
     * 
     * @param   int $id
     */
    public function getById($id)
    {
        return User::with('client_data')->where('id', $id)->first();
    }

    /**
     * Store a newly created client in the db.
     * 
     * @param   \App\Http\Requests\StoreUserRequest $request
     * @return  array
     */
    public function store(StoreUserRequest $request)
    {
        $client = new User($request->except('password'));
        foreach ($request->translations as $code => $value) {
            $client->setTranslation('first_name', $code, $value['first_name']);
            $client->setTranslation('last_name', $code, $value['last_name']);
        }
        $client->verified = 1;
        $client->birthday = Carbon::parse($request->birthday);
        $client->phone_number_verified_at = Carbon::now();
        $client->role = User::ROLE_CLIENT;
        $client->password = Hash::make($request->password);

        if($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $client->save();

        // Save additional client data
        $client->client_data()->save(new ClientData([
            'id_card' => $request->id_card,
            'id_card_expires_at' => Carbon::parse($request->id_card_expires_at),
            'passport_number' => $request->passport_number,
            'passport_expires_at' => Carbon::parse($request->passport_expires_at)
        ]));
    }

    /**
     * Update a specific client.
     * 
     * @param   \App\Http\Requests\UpdateUserRequest $request
     * @param   int $id
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $client = User::find($id);
        foreach ($request->translations as $code => $value) {
            $client->setTranslation('first_name', $code, $value['first_name']);
            $client->setTranslation('last_name', $code, $value['last_name']);
        }
        $client->birthday = Carbon::parse($request->birthday);
        $client->nationality = $request->nationality;
        $client->phone_number = $request->phone_number;
        $client->email = $request->email;
        $client->gender = $request->gender;
        
        if($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->photo, 'user_photos');
        }

        $client->save();

        // Update client's additional data
        $client->client_data()->update([
            'id_card' => $request->id_card,
            'id_card_expires_at' => Carbon::parse($request->id_card_expires_at),
            'passport_number' => $request->passport_number,
            'passport_expires_at' => Carbon::parse($request->passport_expires_at)
        ]);
    }

    /**
     * Get client's count
     */
    public function count()
    {
        return User::where('role', User::ROLE_CLIENT)->get()->count();
    }
}