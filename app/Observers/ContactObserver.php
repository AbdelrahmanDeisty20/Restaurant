<?php

namespace App\Observers;

use App\Models\Contact;
use App\Models\User;
use Filament\Notifications\Notification;

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
            ->icon('heroicon-o-chat-bubble-left-right')
            ->iconColor('success')
            ->actions([
                \Filament\Notifications\Actions\Action::make('view')
                    ->label(__('View'))
                    ->url(fn (): string => \App\Filament\Resources\Contacts\ContactResource::getUrl('view', ['record' => $contact->id])),
            ])
            ->sendToDatabase($admins);
    }
}
