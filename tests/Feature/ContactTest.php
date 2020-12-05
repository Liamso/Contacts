<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Contact;
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
            $this->assertEquals($value, $response['contacts'][0]->$key);
        }
    }
}
