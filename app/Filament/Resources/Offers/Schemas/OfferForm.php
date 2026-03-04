<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OfferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('product_id')
                    ->label(__('Product'))
                    ->required()
                    ->numeric(),
                TextInput::make('discount_percentage')
                    ->label(__('Discount Percentage'))
                    ->required()
                    ->numeric(),
                DateTimePicker::make('start_date')
                    ->label(__('Start Date')),
                DateTimePicker::make('end_date')
                    ->label(__('End Date')),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->required(),
            ]);
    }
}
