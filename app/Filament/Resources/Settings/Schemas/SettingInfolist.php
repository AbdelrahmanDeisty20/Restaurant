<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class SettingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Configuration Details'))
                    ->icon('heroicon-o-adjustments-vertical')
                    ->description(__('Current system setting values and their definitions.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('key')
                                    ->label(__('Key'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-key')
                                    ->copyable(),
                                TextEntry::make('type')
                                    ->label(__('Type'))
                                    ->badge()
                                    ->color('info')
                                    ->icon('heroicon-m-variable'),
                                TextEntry::make('value')
                                    ->label(__('Value'))
                                    ->columnSpanFull()
                                    ->color('primary'),
                            ]),
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
