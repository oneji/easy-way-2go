<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'registered_on' => [ 'required' ],
            'register_country' => [ 'required', 'exists:countries,id' ],
            'translations' => [ 'required' ],
            'car_number' => [ 'required', 'string', 'max:255' ],
            'car_brand_id' => [ 'required', 'numeric', 'exists:car_brands,id' ],
            'car_model_id' => [ 'required', 'numeric', 'exists:car_models,id' ],
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
