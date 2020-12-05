<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:1000',
            'last_name' => 'required|max:1000',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
            'company' => 'required|max:1000',
            'position' => 'required|max:1000',
            'email' => 'nullable|email|max:1000',
        ];
    }
}
