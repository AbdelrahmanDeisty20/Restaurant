<?php

namespace App\Filament\Resources\Addresses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Location Identity'))
                    ->icon('heroicon-o-map')
                    ->description(__('Identification and owner of the address.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label(__('User'))
                                    ->relationship('user', 'full_name') // Fixed relationship
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->prefixIcon('heroicon-m-user'),
                                TextInput::make('title')
                                    ->label(__('Label (e.g. Home, Office)'))
                                    ->required()
                                    ->prefixIcon('heroicon-m-bookmark'),
                            ]),
                    ]),

                Section::make(__('Physical Address'))
                    ->icon('heroicon-o-map-pin')
                    ->description(__('Full physical location details for delivery.'))
                    ->schema([
                        Textarea::make('address')
                            ->label(__('Detailed Address'))
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('Preferences'))
                    ->icon('heroicon-o-star')
                    ->description(__('Set this address as primary or default.'))
                    ->schema([
                        Toggle::make('is_default')
                            ->label(__('Set as Default Address'))
                            ->default(false)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ]),
            ]);
    }
}