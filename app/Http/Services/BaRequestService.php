<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\JsonRequests\StoreBaRequest;
use App\Http\Services\UploadFileService;
use App\BaMainDriverData;
use App\BaFirmOwnerData;
use App\BaRequest;
use App\Brigadir;
use Carbon\Carbon;
use Hash;

class BaRequestService
{
    /**
     * Get all bussiness account requests
     * 
     * @return collection
     */
    public function all()
    {
        return BaRequest::all();
    }
    
    /**
     * Get all bussiness account requests paginated
     * 
     * @return collection
     */
    public function getPaginated()
    {
        return BaRequest::paginate(10);
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
            $baRequest->data = BaMainDriverData::where('ba_request_id', $id)->first();
        }

        return $baRequest;
    }

    /**
     * Store a newly created bussiness account request
     * 
     * @param App\Http\JsonRequests\StoreBaRequest $request
     */
    public function store(StoreBaRequest $request)
    {
        $baRequest = new BaRequest();
        $baRequest->type = $request->type;
        $baRequest->status = 'pending';
        $baRequest->save();

        if($request->type === 'firm_owner') {
            $this->storeFirmOwnerData($request->except('type'), $baRequest->id);
        } else if($request->type === 'head_driver') {
            $this->storeHeadDriverData($request->except('type'), $baRequest->id);
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
     * Store head driver data
     * 
     * @param array $mainDriverData
     */
    private function storeHeadDriverData($data, $baRequestId)
    {
        $mainDriverData = new BaMainDriverData($data);
        $mainDriverData->birthday = Carbon::parse($data['birthday']);
        $mainDriverData->dl_issued_at = Carbon::parse($data['dl_issued_at']);
        $mainDriverData->dl_expires_at = Carbon::parse($data['dl_expires_at']);
        $mainDriverData->grades_expire_at = Carbon::parse($data['grades_expire_at']);
        $mainDriverData->ba_request_id = $baRequestId;

        if(isset($data['driving_license_photos'])) {
            $mainDriverData->driving_license_photos = UploadFileService::uploadMultiple($data['driving_license_photos'], 'ba_requests');
        }

        if(isset($data['passport_photos'])) {
            $mainDriverData->passport_photos = UploadFileService::uploadMultiple($data['passport_photos'], 'ba_requests');
        }

        $mainDriverData->save();
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
    public function approve(Request $request, $id)
    {
        $baRequest = BaRequest::findOrFail($id);
        $baRequest->status = 'approved';
        $baRequest->save();

        $this->createBrigadirByBaRequestId($request->email, $request->password, $id);
    }

    /**
     * Create a new brigadir from firm owner data
     * 
     * @param array $firmOwnerData
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
        $brigadir->verified = 1;
        $brigadir->phone_number_verified_at = Carbon::now();
        $brigadir->password = Hash::make($password);
        $brigadir->email = $email;
        $brigadir->company_name = $firmOwnerData->company_name;
        $brigadir->inn = $firmOwnerData->inn;
        
        $brigadir->save();
    }
}