<?php

namespace App\Filament\Resources\ProductReviews\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ProductReviewInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Review Feedback'))
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->description(__('The specific rating and comments provided by the customer.'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('rating')
                                    ->label(__('Rating'))
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
                            ]),
                        TextEntry::make('comment')
                            ->label(__('Comment'))
                            ->prose()
                            ->columnSpanFull()
                            ->placeholder(__('No written comment provided.')),
                    ]),

                Section::make(__('Review Participants'))
                    ->icon('heroicon-o-users')
                    ->description(__('Details about the reviewer and the product.'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('user.full_name')
                                    ->label(__('Customer'))
                                    ->icon('heroicon-m-user'),
                                TextEntry::make('product.name_' . app()->getLocale())
                                    ->label(__('Product'))
                                    ->icon('heroicon-m-cube'),
                                TextEntry::make('order_review_id')
                                    ->label(__('Linked Order Review'))
                                    ->icon('heroicon-m-hashtag')
                                    ->placeholder(__('Not linked')),
                            ]),
                    ]),
            ]);
    }
}
