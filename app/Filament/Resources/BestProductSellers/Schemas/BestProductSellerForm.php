<?php

namespace App\Filament\Resources\BestProductSellers\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BestProductSellerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('product_id')
                    ->label(__('Product'))
                    ->options(Product::all()->pluck('name_ar', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('name_ar')
                    ->label(__('Name AR (Override)'))
                    ->placeholder(__('Leave empty to use product name')),
                TextInput::make('name_en')
                    ->label(__('Name EN (Override)'))
                    ->placeholder(__('Leave empty to use product name')),
                Textarea::make('description_ar')
                    ->label(__('Description AR (Override)'))
                    ->placeholder(__('Leave empty to use product description')),
                Textarea::make('description_en')
                    ->label(__('Description EN (Override)'))
                    ->placeholder(__('Leave empty to use product description')),
                FileUpload::make('image')
                    ->label(__('Image (Override)'))
                    ->disk('public')
                    ->directory('best_sellers')
                    ->image()
                    ->placeholder(__('Leave empty to use product image')),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
            ]);
    }
}
