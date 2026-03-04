<?php

namespace App\Filament\Resources\OrderReviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OrderReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('order_id')
                    ->label(__('Order'))
                    ->numeric(),
                TextEntry::make('user_id')
                    ->label(__('User'))
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
