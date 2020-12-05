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

        // Check the contact edit page
        $response = $this->get("/contacts/{$contact->id}/edit");
        $response->assertStatus(200);
        $response->assertSee($contact->first_name);
        $response->assertSee($contact->last_name);
        $response->assertSee($contact->email);
        $response->assertSee($contact->date_of_birth->format('Y-m-d'));
        $response->assertSee($contact->company);
        $response->assertSee($contact->position);

        // Check the contact update
        $newData = [
            'first_name' => 'New Name',
            'last_name' => 'New Last Name',
            'email' => 'email@email.com',
            'date_of_birth' => '2000-01-01',
            'company' => 'New Company',
            'position' => 'New Position'
        ];

        $this->followingRedirects();
        $response = $this->put("/contacts/{$contact->id}", $newData);

        $response->assertStatus(200);
        foreach($newData as $key => $value) {
            if ($key === 'date_of_birth') {
                $value = new Carbon($value);
            }

            $this->assertEquals($value, $response['contact']->$key);
        }
    }
}
