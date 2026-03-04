<?php

namespace App\Filament\Resources\DriverReviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DriverReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('driver_id')
                    ->label(__('Driver'))
                    ->numeric(),
                TextEntry::make('order_review_id')
                    ->label(__('Order Review'))
                    ->numeric(),
                TextEntry::make('rating')
                    ->label(__('Rating')),
                TextEntry::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime(),
            ]);
    }
}
