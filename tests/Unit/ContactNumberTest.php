<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactNumberTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that contact numbers are created
     * for a contact using syncAll().
     *
     * @return void
     */
    public function testContactNumbersSync()
    {
        $contact = Contact::factory()->create();

        ContactNumber::syncAll([
            'new' => [
                'number' => '0412341234'
            ],
            1 => [
                'number' => '0499999999'
            ]
        ], 'new', $contact->id);


        $contactNumber = ContactNumber::where('number', '0412341234')->first();
        $this->assertTrue($contactNumber->is_primary);
        $this->assertEquals($contact->id, $contactNumber->contact_id);

        $contactNumber = ContactNumber::where('number', '0499999999')->first();
        $this->assertFalse($contactNumber->is_primary);
        $this->assertEquals($contact->id, $contactNumber->contact_id);

        $this->assertEquals(2, ContactNumber::count());
    }
}
