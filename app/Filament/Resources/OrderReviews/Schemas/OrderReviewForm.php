<?php

namespace App\Filament\Resources\OrderReviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class OrderReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Order Review Context'))
                    ->icon('heroicon-o-shopping-cart')
                    ->description(__('Identification of the customer and the specific order.'))
                    ->columns(2)
                    ->components([
                        Select::make('user_id')
                            ->label(__('Customer'))
                            ->relationship('user', 'full_name') // Correct relation
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-user'),
                        Select::make('order_id')
                            ->label(__('Order'))
                            ->relationship('order', 'id') // Correct relation
                            ->searchable()
                            ->preload()
                            ->required()
                            ->prefixIcon('heroicon-m-hashtag'),
                    ]),

                Section::make(__('Feedback Content'))
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->description(__('How the customer rated their overall experience.'))
                    ->schema([
                        TextInput::make('rating')
                            ->label(__('Rating'))
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->prefixIcon('heroicon-m-star'),
                        Textarea::make('comment')
                            ->label(__('Comment'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
