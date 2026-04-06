<?php

namespace App\Filament\Resources\BestProductSellers\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class BestProductSellerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Core Featured Product'))
                    ->icon('heroicon-o-star')
                    ->description(__('Select the product that will be showcased as a best seller.'))
                    ->schema([
                        Select::make('product_id')
                            ->label(__('Product'))
                            ->options(function () {
                                $soldProducts = \App\Models\Product::withSum('orders as total_sales', 'order_items.quantity')
                                    ->has('orders')
                                    ->orderByDesc('total_sales')
                                    ->get()
                                    ->mapWithKeys(function ($product) {
                                        return [$product->id => $product->name . " ( " . __('Sales') . ": " . (int)$product->total_sales . " )"];
                                    });

                                if ($soldProducts->isEmpty()) {
                                    return \App\Models\Product::all()->pluck('name_ar', 'id');
                                }

                                return $soldProducts;
                            })
                            ->searchable()
                            ->required()
                            ->prefixIcon('heroicon-m-shopping-bag'),
                    ]),

                Section::make(__('Content Overrides'))
                    ->icon('heroicon-o-pencil-square')
                    ->description(__('Optional: Provide custom details instead of using original product info.'))
                    ->collapsible()
                    ->collapsed() // Keep it clean by default
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name_ar')
                                    ->label(__('Name AR (Override)'))
                                    ->placeholder(__('Leave empty to use product name'))
                                    ->prefixIcon('heroicon-m-language'),
                                TextInput::make('name_en')
                                    ->label(__('Name EN (Override)'))
                                    ->placeholder(__('Leave empty to use product name'))
                                    ->prefixIcon('heroicon-m-language'),
                                Textarea::make('description_ar')
                                    ->label(__('Description AR (Override)'))
                                    ->placeholder(__('Leave empty to use product description'))
                                    ->columnSpanFull()
                                    ->rows(3),
                                Textarea::make('description_en')
                                    ->label(__('Description EN (Override)'))
                                    ->placeholder(__('Leave empty to use product description'))
                                    ->columnSpanFull()
                                    ->rows(3),
                                FileUpload::make('image')
                                    ->label(__('Image (Override)'))
                                    ->disk('public')
                                    ->directory('best_sellers')
                                    ->image()
                                    ->imageEditor()
                                    ->columnSpanFull()
                                    ->placeholder(__('Leave empty to use product image')),
                            ]),
                    ]),

                Section::make(__('Display Configuration'))
                    ->icon('heroicon-o-power')
                    ->description(__('Enable or disable this highlight on the storefront.'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('Is Active'))
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ]),
            ]);
    }
}
