<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('Email address'))
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel()
                    ->required(),
                TextInput::make('subject')
                    ->label(__('Subject'))
                    ->required(),
                Textarea::make('message')
                    ->label(__('Message'))
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
