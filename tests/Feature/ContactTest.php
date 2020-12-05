<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Carbon;
use Database\Factories\ContactFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRetreivingContacts()
    {
        $user = User::factory()->create();

        Contact::factory()
            ->times(50)
            ->withDOB()
            ->withEmail()
            ->create();

        $response = $this->actingAs($user)->get('/contacts');

        $response->assertStatus(200);
        $this->assertEquals(20, count($response['contacts']));
        $response->assertViewHas('contacts', Contact::with('contactNumbers')->paginate(20));
    }
    
    public function testSearchingContacts()
    {
        $user = User::factory()->create();

        $testingSearchData = [
            'first_name' => 'Name',
            'last_name' => "Apos'trophe",
            'company' => 'Company',
            'email' => 'test@test.com'
        ];

        Contact::factory()->create($testingSearchData);

        foreach ($testingSearchData as $key => $value) {
            $response = $this->actingAs($user)->get('/contacts?search=' . $value);
            $response->assertStatus(200);
            $this->assertEquals(1, count($response['contacts']), "Searching by {$key} was unsuccessful.");
            $this->assertEquals($value, $response['contacts'][0]->$key, "Searching by {$key} was unsuccessful.");
        }
    }

    public function testEditingContact()
    {
        $user = User::factory()->create();

        $contact = Contact::factory()->withDOB()->withEmail()->create();
        $contactsNumber = $contact->contactNumbers()->first();

        // The data and fields we want to update / check
        $newData = [
            'first_name' => 'New Name',
            'last_name' => 'New Last Name',
            'email' => 'email@email.com',
            'date_of_birth' => '2000-01-01',
            'company' => 'New Company',
            'position' => 'New Position',
            'numbers' => [
                $contactsNumber->id => [
                    'number' => $contactsNumber->number
                ],
            ],
        ];

        // Check the contact edit page
        $response = $this->actingAs($user)->get("/contacts/{$contact->id}/edit");
        $response->assertStatus(200);

        foreach ($contact->toArray() as $key => $value) {
            if (in_array($key, $newData)) {
                $response->assertSee($value);
            }
        }

        $this->followingRedirects();
        $response = $this->put("/contacts/{$contact->id}", $newData);

        // Did we arrive without errors?
        $response->assertStatus(200);
        $this->assertTrue($response['errors']->isEmpty());

        // Did we assign the new datems correctly?
        $newContact = $response['contact']->toArray();
        foreach($newData as $key => $value) {
            if (in_array($key, $newData)) {
                $this->assertEquals($value, $newContact[$key]);
            }
        }
    }
}
