<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BindDriverRequest extends FormRequest
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
            'driver_id' => [ 'required', 'exists:users,id', 'numeric' ],
            'transport_id' => [ 'required', 'exists:transports,id', 'numeric' ]
        ];
    }
}
