<?php

namespace App\Filament\Resources\ProductExtras\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductExtraInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Extra Item Details'))
                    ->icon('heroicon-o-plus-circle')
                    ->description(__('Identification and pricing of the product add-on.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name_ar')
                                    ->label(__('Name AR'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-language'),
                                TextEntry::make('name_en')
                                    ->label(__('Name EN'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-language'),
                                TextEntry::make('price')
                                    ->label(__('Price'))
                                    ->money('EGP')
                                    ->icon('heroicon-m-banknotes')
                                    ->color('success')
                                    ->weight('bold'),
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
