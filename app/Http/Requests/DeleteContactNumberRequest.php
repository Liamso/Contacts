<?php

namespace App\Http\Requests;

use App\Rules\ContactNumberRules;
use Illuminate\Foundation\Http\FormRequest;

class DeleteContactNumberRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => [new ContactNumberRules()]
        ];
    }
}
