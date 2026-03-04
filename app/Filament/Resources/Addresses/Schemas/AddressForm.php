<?php

namespace App\Filament\Resources\Addresses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user.full_name')
                    ->label(__('User'))
                    ->required(),
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required(),
                Textarea::make('address')
                    ->label(__('Address'))
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('is_default')
                    ->label(__('Is Default'))
                    ->required(),
            ]);
    }
}