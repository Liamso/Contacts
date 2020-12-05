<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactNumberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactNumber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => '0' . $this->faker->randomNumber(7),
            'is_primary' => true,
            'contact_id' => null
        ];
    }
}
