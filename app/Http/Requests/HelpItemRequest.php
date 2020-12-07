<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelpItemRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'help_section_id' => 'required|integer|exists:help_sections,id'
        ];
    }
}
