<?php

namespace App\Filament\Resources\ProductExtras\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductExtraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Extra Item Details'))
                    ->icon('heroicon-o-plus-circle')
                    ->description(__('Define the naming and pricing for the product add-on.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('name_ar')
                                    ->label(__('Name AR'))
                                    ->required()
                                    ->icon('heroicon-m-language'),
                                TextInput::make('name_en')
                                    ->label(__('Name EN'))
                                    ->required()
                                    ->icon('heroicon-m-language'),
                                TextInput::make('price')
                                    ->label(__('Price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('EGP')
                                    ->icon('heroicon-m-banknotes'),
                            ]),
                    ]),
            ]);
    }
}
