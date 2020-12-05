<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\BirthdayNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BirthdayNotificationSender implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Send birthday notifications to users who's birthday it is.
     *
     * @return void
     */
    public function handle()
    {
        $contacts = Contact::whereMonth('date_of_birth', date('m'))
            ->whereDay('date_of_birth', date('d'))
            ->whereNotNull('email');

        $contacts->each(fn ($contact) => $contact->notify(new BirthdayNotification()));
    }
}
