<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Services\DriverAuthService;
use Illuminate\Support\Facades\Validator;

class DriverAuthController extends Controller
{
    private $driverAuthService;

    /**
     * AuthController construct function
     * 
     * @param \App\Http\Services\DriverAuthService $driverAuthService
     */
    public function __construct(DriverAuthService $driverAuthService)
    {
        $this->driverAuthService = $driverAuthService;
    }

    /**
     * Store a newly created user in the db.
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable'],
            'country_id' => [ 'required', 'integer', 'exists:countries,id' ],
            'city' => [ 'required', 'string' ],
            'dl_issue_place' => [ 'required', 'integer', 'exists:countries,id' ],
            'dl_issued_at' => [ 'required', 'date' ],
            'dl_expires_at' => [ 'required', 'date' ],
            'driving_experience_id' => [ 'required', 'integer', 'exists:driving_experiences,id' ],
            'grades' => [ 'required', 'integer' ],
            'grades_expire_at' => [ 'required', 'date' ],
        ]);

        if($validator->fails()) {
            return response()->json([
                'ok' => false,
                'errors' => $validator->errors()
            ], 401);
        }

        $response = $this->driverAuthService->register($request);

        return response()->json($response);
    }
}
