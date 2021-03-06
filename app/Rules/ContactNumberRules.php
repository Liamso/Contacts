<?php

namespace App\Rules;

use App\Models\ContactNumber;
use Illuminate\Contracts\Validation\Rule;

class ContactNumberRules implements Rule
{
    /**
     * The error message to pass.
     *
     * @var string
     */
    protected $message;


    /**
     * Check if the contact number is either the 
     * last contact number or a primary contact number.
     * Returns false if either condition is met.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $number = ContactNumber::find($value);
        if ($number->is_primary) { 
            $this->message = 'You cannot delete a primary contact number.';
            return false;
        }

        if($number->contact->contactNumbers()->count() === 1) {
        $this->message = 'A contact must always have one contact number.';
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
