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
                    ->numeric(),
                TextEntry::make('order_review_id')
                    ->numeric(),
                TextEntry::make('rating'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
