<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label(__('Key'))
                    ->required(),
                TextInput::make('value')
                    ->label(__('Value'))
                    ->required(),
                TextInput::make('type')
                    ->label(__('Type'))
                    ->required()
                    ->default('text'),
            ]);
    }
}
