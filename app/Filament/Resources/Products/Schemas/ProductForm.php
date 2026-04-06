<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        $locale = app()->getLocale();
        $otherLocale = $locale === 'ar' ? 'en' : 'ar';

        return $schema
            ->components([
                Section::make(__('General Information'))
                    ->icon('heroicon-o-document-text')
                    ->description(__('Define the product names and descriptions in both languages.'))
                    ->columns(2)
                    ->components([
                        TextInput::make("name_ar")
                            ->label(__('Name AR'))
                            ->required()
                            ->prefixIcon('heroicon-m-language'),
                        TextInput::make("name_en")
                            ->label(__('Name EN'))
                            ->required()
                            ->prefixIcon('heroicon-m-language'),
                        Textarea::make("description_ar")
                            ->label(__('Description AR'))
                            ->required()
                            ->columnSpan(1),
                        Textarea::make("description_en")
                            ->label(__('Description EN'))
                            ->required()
                            ->columnSpan(1),
                    ]),

                Section::make(__('Pricing & Inventory'))
                    ->icon('heroicon-o-currency-dollar')
                    ->description(__('Manage the financial details and availability.'))
                    ->columns(3)
                    ->components([
                        Select::make('category_id')
                            ->label(__('Category'))
                            ->required()
                            ->options(fn() => \App\Models\Category::all()->pluck('name', 'id'))
                            ->prefixIcon('heroicon-m-tag')
                            ->searchable()
                            ->preload(),
                        TextInput::make('price')
                            ->label(__('Price'))
                            ->required(fn($get) => count($get('sizes') ?? []) === 0)
                            ->numeric()
                            ->prefix('EGP')
                            ->prefixIcon('heroicon-m-banknotes')
                            ->hidden(fn($get) => count($get('sizes') ?? []) > 0),
                        TextInput::make('discount_price')
                            ->label(__('Discount Price'))
                            ->numeric()
                            ->prefix('EGP')
                            ->prefixIcon('heroicon-m-receipt-percent')
                            ->hidden(fn($get) => count($get('sizes') ?? []) > 0),
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->required()
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                        Toggle::make('is_featured')
                            ->label(__('Is Featured'))
                            ->required()
                            ->default(false)
                            ->onIcon('heroicon-m-star')
                            ->offIcon('heroicon-o-star'),
                    ]),

                Section::make(__('Product Sizes'))
                    ->icon('heroicon-o-arrows-right-left')
                    ->description(__('Define different variants and their specific prices.'))
                    ->collapsible()
                    ->collapsed(fn($record) => $record?->sizes()->count() === 0)
                    ->components([
                        Repeater::make('sizes')
                            ->relationship('sizes')
                            ->label(__('Sizes & Variations'))
                            ->live()
                            ->itemLabel(fn(array $state): ?string => ($state['name_ar'] ?? $state['name_en'] ?? null) 
                                ? ($state['name_ar'] . ' / ' . $state['name_en'] . ' (' . ($state['price'] ?? 0) . ' EGP)') 
                                : null)
                            ->columns(3)
                            ->grid(['default' => 1])
                            ->cloneable()
                            ->addActionLabel(__('Add Size Variation'))
                            ->components([
                                TextInput::make('name_ar')
                                    ->label(__('Name AR'))
                                    ->required()
                                    ->prefixIcon('heroicon-m-language'),
                                TextInput::make('name_en')
                                    ->label(__('Name EN'))
                                    ->required()
                                    ->prefixIcon('heroicon-m-language'),
                                TextInput::make('price')
                                    ->label(__('Price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('EGP')
                                    ->prefixIcon('heroicon-m-banknotes'),
                            ]),
                    ]),

                Section::make(__('Product Media'))
                    ->icon('heroicon-o-photo')
                    ->description(__('Upload the main representation and additional gallery images.'))
                    ->components([
                        FileUpload::make('main_image')
                            ->label(__('Main Image'))
                            ->disk('public')
                            ->directory('products/main_image')
                            ->image()
                            ->formatStateUsing(fn($state) => $state && !str_contains($state, '/') ? "products/main_image/{$state}" : $state)
                            ->dehydrateStateUsing(fn($state) => $state ? basename($state) : null)
                            ->required()
                            ->imageEditor(),
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
                            ->grid(['default' => 3])
                            ->columnSpanFull()
                            ->reorderable()
                            ->orderColumn('sort'),
                    ]),

                Section::make(__('Additional Details'))
                    ->icon('heroicon-o-plus-circle')
                    ->collapsed()
                    ->components([
                        Select::make('included_extras')
                            ->label(__('Included Extras'))
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(\App\Models\ProductExtra::all()->pluck('name_' . app()->getLocale(), 'id'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
