<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\BaRequestService;
use Illuminate\Support\Facades\Validator;

class BaRequestController extends Controller
{
    private $baService;

    /**
     * BaRequestController constructor
     * 
     * @param \App\Http\Services\BaRequestService $baService
     */
    public function __construct(BaRequestService $baService)
    {
        $this->baService = $baService;
    }

    /**
     * Get a specific bussiness account request by id
     * 
     * @param int $id
     */
    public function getById($id)
    {
        $baRequest = $this->baService->getById($id);

        return response()->json([
            'success' => true,
            'data' => $baRequest
        ]);
    }

    /**
     * Store a newly created bussiness account request
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if(!$request->type) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'type' => [
                        'Field type is required'
                    ]
                ]
            ], 422);
        }

        if($request->type === 'firm_owner') {
            $validator = $this->validateFirmOwnerType($request);

            if(!$validator['success']) {
                return response()->json($validator, 422);
            }
        } elseif($request->type === 'head_driver') {
            $validator = $this->validateHeadDriverType($request);

            if(!$validator['success']) {
                return response()->json($validator, 422);
            }
        }

        $this->baService->store($request);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Validate firm_owner type request
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function validateFirmOwnerType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string',
            'inn' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string|unique:brigadirs|unique:drivers|unique:clients',
            'email' => 'required|email|unique:brigadirs|unique:drivers|unique:clients|unique:users',
            'nationality' => 'required|integer|exists:countries,id',
            'country_id' => 'required|integer|exists:countries,id',
            'city' => 'required|string',
            'passport_photo' => 'required'
        ]);

        if($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return [
            'success' => true
        ];
    }
    
    /**
     * Validate head_driver type request
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function validateHeadDriverType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'drivers' => 'required',
            'drivers.*.first_name' => 'required|string',
            'drivers.*.last_name' => 'required|string',
            'drivers.*.birthday' => 'required',
            'drivers.*.nationality' => 'required|integer|exists:countries,id',
            'drivers.*.phone_number' => 'required|string|unique:drivers|unique:clients|unique:brigadirs',
            'drivers.*.email' => 'required|email|unique:drivers|unique:clients|unique:users|unique:brigadirs',
            'drivers.*.country_id' => 'required|integer|exists:countries,id',
            'drivers.*.city' => 'required|string',
            'drivers.*.dl_issue_place' => 'required|integer|exists:countries,id',
            'drivers.*.dl_issued_at' => 'required',
            'drivers.*.dl_expires_at' => 'required',
            'drivers.*.driving_experience_id' => 'required|integer|exists:driving_experiences,id',
            'drivers.*.conviction' => 'required|integer',
            'drivers.*.comment' => 'required',
            'drivers.*.was_kept_drunk' => 'required|integer',
            'drivers.*.grades' => 'required|integer',
            'drivers.*.grades_expire_at' => 'required',
            'drivers.*.dtp' => 'required|integer',

            'transport' => 'required',
            'transport.registered_on' => 'required',
            'transport.register_country' => 'required|exists:countries,id',
            'transport.register_city' => 'required',
            'transport.car_number' => 'required|string|max:255',
            'transport.car_brand_id' => 'required|numeric|exists:car_brands,id',
            'transport.car_model_id' => 'required|numeric|exists:car_models,id',
            'transport.has_cmr' => 'required|boolean',
            'transport.passengers_seats' => 'required|numeric',
            'transport.cubo_metres_available' => 'required|numeric',
            'transport.kilos_available' => 'required|numeric',
            'transport.ok_for_move' => 'required|boolean',
            'transport.can_pull_trailer' => 'required|boolean',
            'transport.has_trailer' => 'required|boolean',
            'transport.pallet_transportation' => 'required|boolean',
            'transport.air_conditioner' => 'required|boolean',
            'transport.wifi' => 'required|boolean',
            'transport.tv_video' => 'required|boolean',
            'transport.disabled_people_seats' => 'required|boolean',
            'transport.teh_osmotr_date_from' => 'required',
            'transport.teh_osmotr_date_to' => 'required',
            'transport.insurance_date_from' => 'required',
            'transport.insurance_date_to' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        return [
            'success' => true
        ];
    }
}
