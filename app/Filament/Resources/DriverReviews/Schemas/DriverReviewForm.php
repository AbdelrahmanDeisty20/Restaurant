<?php

namespace App\Filament\Resources\DriverReviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DriverReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('driver_id')
                    ->label(__('Driver'))
                    ->required()
                    ->numeric(),
                TextInput::make('order_review_id')
                    ->label(__('Order Review'))
                    ->required()
                    ->numeric(),
                TextInput::make('rating')
                    ->label(__('Rating'))
                    ->required(),
                Textarea::make('comment')
                    ->label(__('Comment'))
                    ->columnSpanFull(),
            ]);
    }
}
