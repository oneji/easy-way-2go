<?php

namespace App\Http\JsonRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransportRequest extends FormRequest
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
            'success' => false,
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
            'registered_on' => [ 'required' ],
            'register_country' => [ 'required', 'exists:countries,id' ],
            'register_city' => [ 'required' ],
            'car_number' => [ 'required', 'string', 'max:255' ],
            'car_brand_id' => [ 'required', 'numeric', 'exists:car_brands,id' ],
            'car_model_id' => [ 'required', 'numeric', 'exists:car_models,id' ],
            'year' => [ 'required', 'string' ],
            'teh_osmotr_date_from' => [ 'required' ],
            'teh_osmotr_date_to' => [ 'required' ],
            'insurance_date_from' => [ 'required' ],
            'insurance_date_to' => [ 'required' ],
            'has_cmr' => [ 'required', 'boolean' ],
            'passengers_seats' => [ 'required', 'numeric' ],
            'cubo_metres_available' => [ 'required', 'numeric' ],
            'kilos_available' => [ 'required', 'numeric' ],
            'ok_for_move' => [ 'required', 'boolean' ],
            'can_pull_trailer' => [ 'required', 'boolean' ],
            'has_trailer' => [ 'required', 'boolean' ],
            'pallet_transportation' => [ 'required', 'boolean' ],
            'air_conditioner' => [ 'required', 'boolean' ],
            'wifi' => [ 'required', 'boolean' ],
            'tv_video' => [ 'required', 'boolean' ],
            'disabled_people_seats' => [ 'required', 'boolean' ],
        ];
    }
}
