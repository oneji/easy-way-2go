<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Services\UploadFileService;
use App\Http\Requests\ApproveBaRequest;
use App\Jobs\SendEmailJob;
use App\BaFirmOwnerData;
use App\BaTransport;
use Carbon\Carbon;
use App\BaRequest;
use App\BaDriver;
use App\Brigadir;
use App\Driver;
use App\Jobs\SyncUserToMongoChatJob;
use App\Transport;

class BaRequestService
{
    /**
     * Get all bussiness account requests
     * 
     * @return collection
     */
    public function all()
    {
        return BaRequest::orderBy('id', 'desc')->get();
    }
    
    /**
     * Get all bussiness account requests paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return BaRequest::orderBy('id', 'desc')->paginate(10);
    }

    /**
     * Get a specific bussiness account request by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $baRequest = BaRequest::find($id);
        
        if($baRequest->type === 'firm_owner') {
            $baRequest->data = BaFirmOwnerData::where('ba_request_id', $id)->first();
        } else {
            $baRequest->load([ 'drivers', 'transport' ]);
        }

        return $baRequest;
    }

    /**
     * Store a newly created bussiness account request
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        $baRequest = new BaRequest();
        $baRequest->type = $request->type;
        $baRequest->status = 'pending';
        $baRequest->save();

        if($request->type === 'firm_owner') {
            $this->storeFirmOwnerData($request->except('type'), $baRequest->id);
        } else if($request->type === 'head_driver') {
            $this->storeRequestDrivers($request->drivers, $baRequest->id);
            $this->storeRequestTransport($request->transport, $baRequest->id);
        }
    }

    /**
     * Store firm owner data
     * 
     * @param array $firmOwnerData
     */
    private function storeFirmOwnerData($data, $baRequestId)
    {
        $firmOwnerData = new BaFirmOwnerData($data);
        $firmOwnerData->birthday = Carbon::parse($data['birthday']);
        $firmOwnerData->ba_request_id = $baRequestId;

        if(isset($data['passport_photo'])) {
            $firmOwnerData->passport_photo = UploadFileService::uploadMultiple($data['passport_photo'], 'ba_requests');
        }

        $firmOwnerData->save();
    }

    /**
     * Store request drivers
     * 
     * @param array $data
     * @param int $baRequestId
     */
    private function storeRequestDrivers($drivers, $baRequestId)
    {
        foreach ($drivers as $driverData) {
            $driver = new BaDriver($driverData);
            $driver->birthday = Carbon::parse($driverData['birthday']);
            $driver->dl_issued_at = Carbon::parse($driverData['dl_issued_at']);
            $driver->dl_expires_at = Carbon::parse($driverData['dl_expires_at']);
            $driver->grades_expire_at = Carbon::parse($driverData['grades_expire_at']);
            $driver->ba_request_id = $baRequestId;
            
            if(isset($data['driving_license_photos'])) {
                $driver->driving_license_photos = UploadFileService::uploadMultiple($driverData['driving_license_photos'], 'ba_requests');
            }

            if(isset($data['passport_photos'])) {
                $driver->passport_photos = UploadFileService::uploadMultiple($driverData['passport_photos'], 'ba_requests');
            }

            $driver->save();
        }
    }

    /**
     * Store request transport
     * 
     * @param object $transportData
     * @param int $baRequestId
     */
    public function storeRequestTransport($transportData, $baRequestId)
    {
        $transport = new BaTransport($transportData);

        // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($transportData['teh_osmotr_date_from']);
        $transport->teh_osmotr_date_to = Carbon::parse($transportData['teh_osmotr_date_to']);
        $transport->insurance_date_from = Carbon::parse($transportData['insurance_date_from']);
        $transport->insurance_date_to = Carbon::parse($transportData['insurance_date_to']);
        $transport->ba_request_id = $baRequestId;
        $transport->save();
    }

    /**
     * Change business account request status
     * 
     * @param int $id
     * @param string $status
     */
    public function decline($id)
    {
        $baRequest = BaRequest::findOrFail($id);
        $baRequest->status = 'declined';
        $baRequest->save();
    }

    /**
     * Change business account request status
     * 
     * @param int $id
     * @param string $status
     */
    public function approve(ApproveBaRequest $request, $id)
    {
        $baRequest = BaRequest::findOrFail($id);
        $baRequest->status = 'approved';
        $baRequest->save();

        if($baRequest->type === 'firm_owner') {
            $this->createBrigadirByBaRequestId($request->email, $request->password, $id);
        } elseif($baRequest->type === 'head_driver') {
            $drivers = $this->createDriverByBaRequestId($id);
            $this->createTransportByBaRequestId($baRequest->transport, $drivers, $baRequest->id);
        }
    }

    /**
     * Create a new brigadir from firm owner data
     * 
     * @param string $email
     * @param string $password
     * @param int $id
     */
    private function createBrigadirByBaRequestId($email, $password, $id)
    {
        $firmOwnerData = BaFirmOwnerData::where('ba_request_id', $id)->first();

        $brigadir = new Brigadir();
        $brigadir->first_name = $firmOwnerData->first_name;
        $brigadir->last_name = $firmOwnerData->last_name;
        $brigadir->birthday = Carbon::parse($firmOwnerData['birthday']);
        $brigadir->nationality = $firmOwnerData->nationality;
        $brigadir->phone_number = $firmOwnerData->phone_number;
        $brigadir->password = Hash::make($password);
        $brigadir->email = $email;
        $brigadir->company_name = $firmOwnerData->company_name;
        $brigadir->inn = $firmOwnerData->inn;
        $brigadir->role = 'brigadir';
        
        $brigadir->save();

        SyncUserToMongoChatJob::dispatch($brigadir->toArray());
        SendEmailJob::dispatch($email, $password);
    }
    
    /**
     * Create a new driver from head driver data
     * 
     * @param string $email
     * @param string $password
     * @param int $id
     */
    private function createDriverByBaRequestId($id)
    {
        $baDrivers = BaDriver::where('ba_request_id', $id)->get();
        $drivers = [];
        
        foreach ($baDrivers as $driverData) {
            $rawPassword = uniqid();
            
            $driver = new Driver();
            $driver->gender = 1;
            $driver->first_name = $driverData['first_name'];
            $driver->last_name = $driverData['last_name'];
            $driver->nationality = $driverData['nationality'];
            $driver->city = $driverData['city'];
            $driver->comment = $driverData['comment'];
            $driver->phone_number = $driverData['phone_number'];
            $driver->email = $driverData['email'];
            $driver->birthday = $driverData['birthday'];
            $driver->country_id = $driverData['country_id'];
            $driver->dl_issue_place = $driverData['dl_issue_place'];
            $driver->driving_experience_id = $driverData['driving_experience_id'];
            $driver->dl_issued_at = Carbon::parse($driverData['dl_issued_at']);
            $driver->dl_expires_at = Carbon::parse($driverData['dl_expires_at']);
            $driver->driving_experience_id = $driverData['driving_experience_id'];
            $driver->conviction = isset($driverData['conviction']) ? 1 : 0;
            $driver->was_kept_drunk = isset($driverData['was_kept_drunk']) ? 1 : 0;
            $driver->dtp = isset($driverData['dtp']) ? 1 : 0;
            $driver->grades = $driverData['grades'];
            $driver->grades_expire_at = Carbon::parse($driverData['grades_expire_at']);
            $driver->password = Hash::make($rawPassword);
            $driver->driving_license_photos = $driverData['driving_license_photos'];
            $driver->passport_photos = $driverData['passport_photos'];
            $driver->role = 'head_driver';
            $driver->save();

            $drivers[] = $driver->id;

            SyncUserToMongoChatJob::dispatch($driver->toArray());
            SendEmailJob::dispatch($driver->email, $rawPassword);
        }

        return $drivers;
    }

    /**
     * Create a transport by ba request id
     * 
     * @param array $drivers
     * @param int $baRequestId
     */
    public function createTransportByBaRequestId($transportData, $drivers, $baRequestId)
    {
        $transport = new Transport();
        $transport->registered_on = $transportData->registered_on;
        $transport->register_country = $transportData->register_country;
        $transport->register_city = $transportData->register_city;
        $transport->car_number = $transportData->car_number;
        $transport->car_brand_id = $transportData->car_brand_id;
        $transport->car_model_id = $transportData->car_model_id;
        $transport->year = $transportData->year;
        // Save parsed date fields
        $transport->teh_osmotr_date_from = Carbon::parse($transportData['teh_osmotr_date_from']);
        $transport->teh_osmotr_date_to = Carbon::parse($transportData['teh_osmotr_date_to']);
        $transport->insurance_date_from = Carbon::parse($transportData['insurance_date_from']);
        $transport->insurance_date_to = Carbon::parse($transportData['insurance_date_to']);
        // ***
        $transport->has_cmr = $transportData->has_cmr;
        $transport->passengers_seats = $transportData->passengers_seats; 
        $transport->cubo_metres_available = $transportData->cubo_metres_available; 
        $transport->kilos_available = $transportData->kilos_available; 
        $transport->ok_for_move = $transportData->ok_for_move; 
        $transport->can_pull_trailer = $transportData->can_pull_trailer; 
        $transport->has_trailer = $transportData->has_trailer; 
        $transport->pallet_transportation = $transportData->pallet_transportation; 
        $transport->air_conditioner = $transportData->air_conditioner; 
        $transport->wifi = $transportData->wifi; 
        $transport->tv_video = $transportData->tv_video; 
        $transport->disabled_people_seats = $transportData->disabled_people_seats;
        $transport->save();

        // Bind drivers to the transport
        $transport->drivers()->attach($drivers);
    }
}