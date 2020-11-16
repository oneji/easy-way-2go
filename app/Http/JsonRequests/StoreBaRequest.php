<?php

namespace App\Http\JsonRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Failed validation disable redirect
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'ok' => false,
            'errors' => $validator->errors()
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            // Drivers validation rules
            'drivers' => Rule::requiredIf(function() {
                return request()->type === 'head_driver';
            }),
            'drivers.*.first_name' => 'required|string',
            'drivers.*.last_name' => 'required|string',
            'drivers.*.birthday' => 'required',
            'drivers.*.nationality' => 'required|integer|exists:countries,id',
            'drivers.*.phone_number' => 'required|string',
            'drivers.*.email' => 'required|email',
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
            // Transport validation rules
            'transport' => Rule::requiredIf(function() {
                return request()->type === 'head_driver';
            }),
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
        ];
    }
}
