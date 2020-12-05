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
            'date_of_birth' => 'nullable|date_format:Y-m-d|before:now',
            'company' => 'required|max:1000',
            'position' => 'required|max:1000',
            'email' => 'nullable|email|max:1000',
            'numbers' => 'array|required|min:1',
            'numbers.*.number' => 'required|min:8|numeric|startswith:0',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages() {
        $messages = [
            'numbers.required' => 'You must supply at least one phone number.'
        ];
    
        if (is_array($this->numbers)) {
            foreach ($this->numbers as $key => $val) {
                $messages["numbers.$key.number.startswith"] = "Phone numbers must begin with a '0' area code.";
                $messages["numbers.$key.number.numeric"] = "Phone numbers must be only digits.";
                $messages["numbers.$key.number.min"] = "Phone numbers must be at least 8 characters in length.";
            }
        }

        return $messages;
    }
}
