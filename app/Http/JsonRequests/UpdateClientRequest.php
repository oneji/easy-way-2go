<?php

namespace App\Http\JsonRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|integer',
            'birthday' => 'required',
            'nationality' => 'required|integer|exists:countries,id',
            'phone_number' => 'required|string',
            'email' => 'required',
            'id_card' => 'required|string',
            'id_card_expires_at' => 'required',
            'passport_number' => 'required|string',
            'passport_expires_at' => 'required'
        ];
    }
}
