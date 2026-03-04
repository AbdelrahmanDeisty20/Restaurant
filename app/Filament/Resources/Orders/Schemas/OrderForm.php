<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->label(__('User'))
                    ->required()
                    ->numeric(),
                TextInput::make('total_price')
                    ->label(__('Total Price'))
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->label(__('Status'))
                    ->required()
                    ->default('pending'),
                TextInput::make('notes')
                    ->label(__('Notes')),
            ]);
    }
}
