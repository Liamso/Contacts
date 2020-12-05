<?php

namespace Tests\Feature;

use Tests\TestCase;
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
        Contact::factory()
            ->times(50)
            ->withDOB()
            ->withEmail()
            ->create();

        $response = $this->get('/contacts');

        $response->assertStatus(200);
        $this->assertEquals(20, count($response['contacts']));
        $response->assertViewHas('contacts', Contact::paginate(20));
    }
    
    public function testSearchingContacts()
    {
        $testingSearchData = [
            'first_name' => 'Name',
            'last_name' => "Apos'trophe",
            'company' => 'Company',
            'email' => 'test@test.com'
        ];

        Contact::factory()->create($testingSearchData);

        foreach ($testingSearchData as $key => $value) {
            $response = $this->get('/contacts?search=' . $value);
            $response->assertStatus(200);
            $this->assertEquals(1, count($response['contacts']), "Searching by {$key} was unsuccessful.");
            $this->assertEquals($value, $response['contacts'][0]->$key, "Searching by {$key} was unsuccessful.");
        }
    }

    public function testEditingContact()
    {
        $contact = Contact::factory()->withDOB()->withEmail()->create();

        // The data and fields we want to update / check
        $newData = [
            'first_name' => 'New Name',
            'last_name' => 'New Last Name',
            'email' => 'email@email.com',
            'date_of_birth' => '2000-01-01',
            'company' => 'New Company',
            'position' => 'New Position'
        ];

        // Check the contact edit page
        $response = $this->get("/contacts/{$contact->id}/edit");
        $response->assertStatus(200);

        foreach ($contact->toArray() as $key => $value) {
            if (in_array($key, $newData)) {
                $response->assertSee($value);
            }
        }

        $this->followingRedirects();
        $response = $this->put("/contacts/{$contact->id}", $newData);

        // Did we assign the new datems correctly?
        $response->assertStatus(200);
        $newContact = $response['contact']->toArray();
        foreach($newData as $key => $value) {
            if (in_array($key, $newData)) {
                $this->assertEquals($value, $newContact[$key]);
            }
        }
    }
}
