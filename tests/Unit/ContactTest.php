<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a primary contact number
     * can be fetched for a contact using
     * primaryPhone.
     *
     * @return void
     */
    public function testPrimaryContactNumber()
    {
        $contact = Contact::factory()->create();

        ContactNumber::syncAll([
            'new' => [
                'number' => '0412341234'
            ],
            $contact->contactNumbers()->first()->id => [
                'number' => '0499999999'
            ],
        ], 'new', $contact->id);

        $contactNumber = $contact->primaryPhone;

        $this->assertEquals('0412341234', $contactNumber->number);
        $this->assertTrue($contactNumber->is_primary);
    }
}
