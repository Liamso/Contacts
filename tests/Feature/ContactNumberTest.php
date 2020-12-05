<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use App\Models\ContactNumber;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactNumberTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test deleting a contact number.
     *
     * @return void
     */
    public function testDeletingContactNumber()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();

        // Create a deleteable contact number
        $contactNumber = ContactNumber::factory()->create([
            'contact_id' => $contact->id,
            'is_primary' => false,
        ]);

        // Delete the contact number
        $this->followingRedirects();
        $response = $this->actingAs($user)->delete('/contact-numbers', [
            'id' => $contactNumber->id
        ]);

        $response->assertStatus(200);
        $this->assertTrue($response['errors']->isEmpty());
        $this->assertEmpty($contactNumber->fresh());
    }
    
    /**
     * Test that a user can't delete the primary or last contact
     * number for a user.
     *
     * @return void
     */
    public function testCantDeleteLastContactNumber()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $contactsNumber = $contact->contactNumbers()->first();
        // Delete the contact number
        $response = $this->actingAs($user)->get("/contacts/{$contact->id}/edit");

        $this->followingRedirects();
        $response = $this->actingAs($user)->delete('/contact-numbers', [
            'id' => $contactsNumber->id
        ]);

        $response->assertSee('You cannot delete a primary contact number.');
    }
}
