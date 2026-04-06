<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('System Configuration'))
                    ->icon('heroicon-o-cog-8-tooth')
                    ->description(__('Manage global application settings and parameters.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('key')
                                    ->label(__('Key'))
                                    ->required()
                                    ->disabled(fn(string $context): bool => $context !== 'create')
                                    ->icon('heroicon-m-key'),
                                TextInput::make('type')
                                    ->label(__('Type'))
                                    ->required()
                                    ->default('text')
                                    ->icon('heroicon-m-variable'),
                                TextInput::make('value')
                                    ->label(__('Value'))
                                    ->required()
                                    ->columnSpanFull()
                                    ->icon('heroicon-m-adjustments-vertical'),
                            ]),
                    ]),
            ]);
    }
}
