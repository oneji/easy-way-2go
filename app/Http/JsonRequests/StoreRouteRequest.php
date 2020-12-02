<?php

namespace App\Http\JsonRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class StoreRouteRequest extends FormRequest
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
            'addresses' => 'required',
            'repeats' => 'required',
            'addresses.*.place_id' => 'required',
            'addresses.*.order' => 'required|integer',
            'addresses.*.country_id' => 'required|exists:countries,id',
            'addresses.*.address' => 'required|string',
            'addresses.*.departure_date' => 'required|date',
            'addresses.*.departure_time' => 'required|string',
            'addresses.*.arrival_date' => 'required|date',
            'addresses.*.arrival_time' => 'required|string',
            'addresses.*.type' => 'required',
            'repeats.*.from' => 'required',
            'repeats.*.to' => 'required',
            'transport_id' => 'required'
        ];
    }
}
