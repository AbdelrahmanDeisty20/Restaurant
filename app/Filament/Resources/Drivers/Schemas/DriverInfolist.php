<?php

namespace App\Filament\Resources\Drivers\Schemas;

use App\Filament\Resources\Users\UserResource;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class DriverInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Driver Identification'))
                    ->icon('heroicon-o-identification')
                    ->description(__('Primary profile details and driver image.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                ImageEntry::make('avatar')
                                    ->label(__('Avatar'))
                                    ->disk('public')
                                    ->circular()
                                    ->size(100),
                                TextEntry::make('name')
                                    ->label(__('Driver Name'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-user')
                                    ->columnSpan(2),
                            ]),
                    ]),

                Section::make(__('Availability & Contact'))
                    ->icon('heroicon-o-signal')
                    ->description(__('Current work status and reaching the driver.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('phone')
                                    ->label(__('Phone'))
                                    ->icon('heroicon-m-phone')
                                    ->copyable(),
                                TextEntry::make('status')
                                    ->label(__('Current Status'))
                                    ->badge()
                                    ->color(fn(string $state): string => match ($state) {
                                        'available' => 'success',
                                        'busy' => 'warning',
                                        'offline' => 'danger',
                                        default => 'gray',
                                    })
                                    ->icon('heroicon-m-flag')
                                    ->formatStateUsing(fn(string $state): string => __($state)),
                            ]),
                    ]),

                Section::make(__('Metadata'))
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('Joined At'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar'),
                                TextEntry::make('updated_at')
                                    ->label(__('Last Update'))
                                    ->dateTime()
                                    ->icon('heroicon-m-clock'),
                            ]),
                    ]),
            ]);
    }
}
