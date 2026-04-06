<?php

namespace App\Filament\Resources\DriverReviews\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class DriverReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Review Context'))
                    ->icon('heroicon-o-truck')
                    ->description(__('Identification of the driver and the order review relationship.'))
                    ->columns(2)
                    ->components([
                        Select::make('driver_id')
                            ->label(__('Driver'))
                            ->relationship('driver', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->icon('heroicon-m-identification'),
                        Select::make('order_review_id')
                            ->label(__('Order Review'))
                            ->relationship('orderReview', 'id') // Assuming id is the best label here
                            ->required()
                            ->searchable()
                            ->preload()
                            ->icon('heroicon-m-hashtag'),
                    ]),

                Section::make(__('Feedback Details'))
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->description(__('The rating and specific feedback for the driver.'))
                    ->schema([
                        TextInput::make('rating')
                            ->label(__('Rating'))
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(5)
                            ->icon('heroicon-m-star'),
                        Textarea::make('comment')
                            ->label(__('Comment'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
