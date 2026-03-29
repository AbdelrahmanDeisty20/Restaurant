<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        $locale = app()->getLocale();
        $otherLocale = $locale === 'ar' ? 'en' : 'ar';

        return $schema
            ->components([
                TextInput::make("name_{$locale}")
                    ->label($locale === 'ar' ? __('Name AR') : __('Name EN'))
                    ->required(),
                TextInput::make("name_{$otherLocale}")
                    ->label($otherLocale === 'ar' ? __('Name AR') : __('Name EN'))
                    ->required(),
                Textarea::make("description_{$locale}")
                    ->label($locale === 'ar' ? __('Description AR') : __('Description EN'))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make("description_{$otherLocale}")
                    ->label($otherLocale === 'ar' ? __('Description AR') : __('Description EN'))
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('main_image')
                    ->label(__('Main Image'))
                    ->disk('public')
                    ->directory('products/main_image')
                    ->image()
                    ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "products/main_image/{$state}" : $state)
                    ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                    ->required(),

                Repeater::make('images')
                    ->relationship('images')
                    ->label(__('Product Gallery'))
                    ->schema([
                        FileUpload::make('images')
                            ->label(__('Image'))
                            ->disk('public')
                            ->directory('products/images')
                            ->image()
                            ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "products/images/{$state}" : $state)
                            ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                            ->required(),
                    ])
                    ->grid(3)
                    ->columnSpanFull()
                    ->reorderable('sort'),

                Select::make('category_id')
                    ->label(__('Category'))
                    ->required()
                    ->options(fn() => \App\Models\Category::all()->pluck('name', 'id')),

                TextInput::make('price')
                    ->label(__('Price'))
                    ->required()
                    ->numeric()
                    ->prefix('EGP'),
                TextInput::make('discount_price')
                    ->label(__('Discount Price'))
                    ->numeric()
                    ->prefix('EGP'),

                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->required()
                    ->default(true),
                Toggle::make('is_featured')
                    ->label(__('Is Featured'))
                    ->required()
                    ->default(false),

                Textarea::make('included_extras')
                    ->label(__('Included Extras'))
                    ->placeholder(__('e.g. Ranch Sauce, Pepsi, ...'))
                    ->columnSpanFull(),

            ]);
    }
}
