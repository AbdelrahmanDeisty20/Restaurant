<?php

namespace App\Filament\Resources\ProductReviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_review_id')
                    ->label(__('Order Review'))
                    ->numeric(),
                TextInput::make('product_id')
                    ->label(__('Product'))
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->label(__('User'))
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
