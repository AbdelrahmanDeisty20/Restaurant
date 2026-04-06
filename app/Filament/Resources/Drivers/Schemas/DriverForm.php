<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Driver Identity'))
                    ->icon('heroicon-o-identification')
                    ->description(__('Basic profile and contact details for the driver.'))
                    ->columns(2)
                    ->components([
                        FileUpload::make('avatar')
                            ->label(__('Avatar'))
                            ->disk('public')
                            ->directory('drivers/avatars')
                            ->image()
                            ->avatar()
                            ->imageEditor()
                            ->columnSpan(1),
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpan(1),
                    ]),

                Section::make(__('Availability & Contact'))
                    ->icon('heroicon-o-signal')
                    ->description(__('Current status and phone number for communication.'))
                    ->columns(2)
                    ->components([
                        TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->required()
                            ->prefixIcon('heroicon-m-phone'),
                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'available' => __('Available'),
                                'busy' => __('Busy'),
                                'offline' => __('Offline'),
                            ])
                            ->required()
                            ->default('available')
                            ->native(false)
                            ->prefixIcon('heroicon-m-flag'),
                    ]),
            ]);
    }
}
