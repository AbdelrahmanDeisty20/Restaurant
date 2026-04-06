<?php

namespace App\Filament\Resources\ProductReviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Review Participants'))
                    ->icon('heroicon-o-users')
                    ->description(__('Identification of the user and the product being reviewed.'))
                    ->columns(2)
                    ->components([
                        Select::make('user_id')
                            ->relationship('user', 'full_name') // Fixed relationship
                            ->label(__('Customer'))
                            ->searchable()
                            ->preload()
                            ->prefixIcon('heroicon-m-user'),
                        Select::make('product_id')
                            ->relationship('product', 'name_ar') // Fixed relationship or default
                            ->label(__('Product'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->prefixIcon('heroicon-m-cube'),
                    ]),

                Section::make(__('Feedback Content'))
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->description(__('The rating and specific comments provided.'))
                    ->components([
                        TextInput::make('rating')
                            ->label(__('Rating'))
                            ->required()
                            ->numeric()
                            ->prefixIcon('heroicon-m-star')
                            ->minValue(1)
                            ->maxValue(5),
                        Textarea::make('comment')
                            ->label(__('Comment'))
                            ->columnSpanFull()
                            ->rows(4)
                            ->prefixIcon('heroicon-m-chat-bubble-left'),
                    ]),
            ]);
    }
}
