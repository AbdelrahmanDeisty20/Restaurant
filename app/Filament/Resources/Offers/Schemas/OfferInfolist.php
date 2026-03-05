<?php

namespace App\Filament\Resources\Offers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OfferInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('product.name')
                    ->label(__('Product')),
                TextEntry::make('discount_percentage')
                    ->label(__('Discount Percentage'))
                    ->numeric(),
                TextEntry::make('start_date')
                    ->label(__('Start Date'))
                    ->dateTime(),
                TextEntry::make('end_date')
                    ->label(__('End Date'))
                    ->dateTime(),
                IconEntry::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean(),
            ]);
    }
}
