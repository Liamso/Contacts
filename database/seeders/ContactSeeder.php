<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Generates some contacts with a combination of
     * the email and date of birth fields filled out.
     *
     * @return void
     */
    public function run()
    {
        Contact::factory()
            ->times(50)
            ->create();

        Contact::factory()
            ->times(50)
            ->withEmail()
            ->create();

        Contact::factory()
            ->times(50)
            ->withDOB()
            ->create();

        Contact::factory()
            ->times(50)
            ->withDOB()
            ->withEmail()
            ->create();
    }
}
