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
use App\Driver;
use App\Jobs\SyncUserToMongoChatJob;
use App\Transport;

class BaRequestService
{
    protected $brigadirService;
    protected $driverService;
    
    /**
     * Create a new instance of BaRequestService
     * 
     * @param \App\Http\Services\BrigadirService $brigadirService
     * @param \App\Http\Services\DriverService $driverService
     */
    public function __construct(BrigadirService $brigadirService, DriverService $driverService)
    {
        $this->brigadirService = $brigadirService;
        $this->driverService = $driverService;
    }

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
        $baRequest = BaRequest::findOrFail($id);
        
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
        $dataToSave = $firmOwnerData->replicate();
        $dataToSave['password'] = $password;

        $this->brigadirService->storeNew($dataToSave);

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
            $driverData['password'] = $rawPassword;
            $driver = $this->driverService->storeNew($driverData);

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