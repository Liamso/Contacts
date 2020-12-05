<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Defines the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company' => $this->faker->company,
            'position' => $this->faker->jobTitle,
        ];
    }
    
    /**
     * Adds a generated date of birth field to the record being generated.
     *
     * @return static
     */
    public function withDOB()
    {
        return $this->state(function (array $attributes) {
            return [
                'date_of_birth' => $this->faker->date('Y-m-d', '2000-01-01')
            ];
        });
    }
    
    /**
     * Adds a generated email field to the record being generated.
     *
     * @return static
     */
    public function withEmail()
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => $this->faker->email
            ];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function (Contact $contact) {
            ContactNumber::factory()->create([
                'contact_id' => $contact->id
            ]);
        });
    }
}
