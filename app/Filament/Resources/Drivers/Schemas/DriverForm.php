<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('avatar'),
                TextInput::make('rating')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('available'),
            ]);
    }
}
