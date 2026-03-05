<?php

namespace App\Filament\Resources\ProductExtras\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductExtraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Name AR'))
                    ->required(),
                TextInput::make('name_en')
                    ->label(__('Name EN'))
                    ->required(),
                TextInput::make('price')
                    ->label(__('Price'))
                    ->required()
                    ->numeric()
                    ->prefix('EGP'),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'size' => __('Size'),
                        'extra' => __('Extra'),
                    ])
                    ->required()
                    ->default('size'),
            ]);
    }
}
