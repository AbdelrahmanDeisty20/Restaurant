<?php

namespace App\Filament\Resources\OrderReviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_id')
                    ->label(__('Order'))
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->label(__('User'))
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
