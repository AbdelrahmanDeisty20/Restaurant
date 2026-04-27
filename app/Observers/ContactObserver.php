<?php

namespace App\Observers;

use App\Models\Contact;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use App\Filament\Resources\Contacts\ContactResource;

class ContactObserver
{
    public function created(Contact $contact): void
    {
        try {
            $admins = User::role(['super_admin', 'admin'])->get();

            Notification::make()
                ->title(__('New Contact Message'))
                ->body(__('From: :name - Subject: :subject', [
                    'name' => $contact->name,
                    'subject' => $contact->subject,
                ]))
                ->icon('heroicon-o-envelope')
                ->iconColor('success')
                ->actions([
                    Action::make('view')
                        ->label(__('View'))
                        ->url(ContactResource::getUrl('view', ['record' => $contact->id])),
                ])
                ->sendToDatabase($admins);
        } catch (\Exception $e) {
            \Log::error("Failed to send admin notification for contact message: " . $e->getMessage());
        }
    }
}
