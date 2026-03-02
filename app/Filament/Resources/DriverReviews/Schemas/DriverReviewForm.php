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
                    ->required()
                    ->numeric(),
                TextInput::make('order_review_id')
                    ->required()
                    ->numeric(),
                TextInput::make('rating')
                    ->required(),
                Textarea::make('comment')
                    ->columnSpanFull(),
            ]);
    }
}
