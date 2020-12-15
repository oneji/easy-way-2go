<?php

namespace App\Http\JsonRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class RegisterDriverRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:users', 'unique:drivers', 'unique:clients', 'unique:brigadirs'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:drivers', 'unique:clients', 'unique:brigadirs'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'photo' => ['nullable'],
            'country' => [ 'required', 'integer', 'exists:countries,id' ],
            'city' => [ 'required', 'string' ],
            'dl_issue_place' => [ 'required', 'integer', 'exists:countries,id' ],
            'dl_issued_at' => [ 'required', 'date' ],
            'dl_expires_at' => [ 'required', 'date' ],
            'driving_experience_id' => [ 'required', 'integer', 'exists:driving_experiences,id' ],
            'grades' => [ 'required', 'integer' ],
            'grades_expire_at' => [ 'required', 'date' ],
            'nationality' => 'required|integer|exists:countries,id',
            'country_id' => 'required|integer|exists:countries,id'
        ];
    }
}
