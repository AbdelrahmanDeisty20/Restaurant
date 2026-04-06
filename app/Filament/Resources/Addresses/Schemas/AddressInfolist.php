<?php

namespace App\Filament\Resources\Addresses\Schemas;

use App\Filament\Resources\Users\UserResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AddressInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Location Identification'))
                    ->icon('heroicon-o-map')
                    ->description(__('Who owns this location and what is it labeled.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('user.full_name')
                                    ->label(__('Customer'))
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-m-user')
                                    ->url(fn($record) => UserResource::getUrl('view', ['record' => $record->user]))
                                    ->openUrlInNewTab(),
                                TextEntry::make('title')
                                    ->label(__('Label'))
                                    ->icon('heroicon-m-bookmark'),
                                TextEntry::make('is_default')
                                    ->label(__('Preference'))
                                    ->badge()
                                    ->color(fn(bool $state): string => $state ? 'success' : 'gray')
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Default Address') : __('Standard')),
                            ]),
                    ]),

                Section::make(__('Physical Details'))
                    ->icon('heroicon-o-map-pin')
                    ->description(__('Full physical location used for delivery.'))
                    ->schema([
                        TextEntry::make('address')
                            ->label(__('Complete Address'))
                            ->prose()
                            ->columnSpanFull()
                            ->icon('heroicon-m-map-pin'),
                    ]),

                Section::make(__('Metadata'))
                    ->icon('heroicon-o-information-circle')
                    ->collapsed()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('Created At'))
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
