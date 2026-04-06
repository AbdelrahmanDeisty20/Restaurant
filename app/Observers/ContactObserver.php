<?php

namespace App\Observers;

use App\Models\Contact;
use App\Models\User;
use Filament\Notifications\Notification;
use App\Filament\Resources\Contacts\ContactResource;

class ContactObserver
{
    /**
     * Handle the Contact "created" event.
     */
    public function created(Contact $contact): void
    {
        $admins = User::role(['super_admin', 'admin'])->get();

        Notification::make()
            ->title(__('New Contact Message'))
            ->body(__('From: :name - Subject: :subject', [
                'name' => $contact->name,
                'subject' => $contact->subject,
            ]))
            ->icon('heroicon-o-envelope')
            ->iconColor('success')
            ->url(ContactResource::getUrl('view', ['record' => $contact->id]))
            ->sendToDatabase($admins);
    }
}
