<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('phone')
                    ->label(__('Phone'))
                    ->tel()
                    ->required(),
                FileUpload::make('avatar')
                    ->label(__('Avatar'))
                    ->disk('public')
                    ->directory('drivers/avatars')
                    ->image(),
                TextInput::make('status')
                    ->label(__('Status'))
                    ->required()
                    ->default('available'),
            ]);
    }
}
