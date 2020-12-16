<?php

namespace App\Http\JsonRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDriverRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required|integer',
            'birthday' => 'required|date',
            'nationality' => 'required|integer|exists:countries,id',
            'phone_number' => [ 'required', 'string', Rule::unique('drivers')->ignore($this->id) ],
            'photo' => 'nullable',
            'email' => [ 'required', Rule::unique('drivers')->ignore($this->id) ],
            'country_id' => 'required|integer|exists:countries,id',
            'city' => 'required|string|max:255',
            'dl_issue_place' => 'required|integer|exists:countries,id',
            'dl_issued_at' => 'required|date',
            'dl_expires_at' => 'required|date',
            'conviction' => 'required|integer',
            'dtp' => 'required|integer',
            'was_kept_drunk' => 'required|integer',
            'grades' => 'required|integer',
            'grades_expire_at' => 'required|date',
            'driving_experience_id' => 'required|integer|exists:driving_experiences,id'
        ];
    }
}
