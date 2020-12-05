<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Contact;
use App\Jobs\BirthdayNotificationSender;
use App\Notifications\BirthdayNotification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BirthdayNotificationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that birthday notifications are sent on contact birthdays.
     *
     * @return void
     */
    public function testBirthdayNotificationIsSent()
    {
        Notification::fake();
        $contacts = Contact::factory()->times(10)->withEmail()->create([
            'date_of_birth' => Carbon::now()->subYears(30)->format('Y-m-d')
        ]);
        
        $badContacts = Contact::factory()->times(10)->create([
            'date_of_birth' => Carbon::now()->subYears(30)->format('Y-m-d')
        ]);

        $job = new BirthdayNotificationSender();
        $job->handle();

        Notification::assertSentTo($contacts, BirthdayNotification::class);
        Notification::assertNotSentTo($badContacts, BirthdayNotification::class);
    }
}
