<?php

namespace App\Filament\Resources\OrderReviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class OrderReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Review Feedback'))
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->description(__('Rating and comments provided for this order.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('rating')
                                    ->label(__('Overall Rating'))
                                    ->badge()
                                    ->color(fn(int $state): string => match (true) {
                                        $state >= 4 => 'success',
                                        $state === 3 => 'warning',
                                        default => 'danger',
                                    })
                                    ->icon('heroicon-m-star'),
                                TextEntry::make('created_at')
                                    ->label(__('Posted At'))
                                    ->dateTime()
                                    ->icon('heroicon-m-calendar'),
                                TextEntry::make('updated_at')
                                    ->label(__('Last Edit'))
                                    ->dateTime()
                                    ->icon('heroicon-m-clock'),
                            ]),
                        TextEntry::make('comment')
                            ->label(__('Comment'))
                            ->prose()
                            ->columnSpanFull()
                            ->placeholder(__('No written comment provided.')),
                    ]),

                Section::make(__('Review Context'))
                    ->icon('heroicon-o-shopping-cart')
                    ->description(__('Identification of the customer and order details.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('user.full_name')
                                    ->label(__('Customer Name'))
                                    ->weight('bold')
                                    ->icon('heroicon-m-user'),
                                TextEntry::make('order.id')
                                    ->label(__('Order ID'))
                                    ->icon('heroicon-m-hashtag')
                                    ->copyable(),
                            ]),
                    ]),
            ]);
    }
}
