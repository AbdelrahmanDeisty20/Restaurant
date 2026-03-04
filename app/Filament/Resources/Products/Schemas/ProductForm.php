<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
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
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Name AR'))
                    ->required(),
                TextInput::make('name_en')
                    ->label(__('Name EN'))
                    ->required(),
                Textarea::make('description_ar')
                    ->label(__('Description AR'))
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description_en')
                    ->label(__('Description EN'))
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('main_image')
                    ->label(__('Main Image'))
                    ->disk('public')
                    ->directory('products/images')
                    ->image()
                    ->required(),
                Select::make('category_id')
                    ->label(__('Category'))
                    ->required()
                    ->options(fn() => Category::all()->pluck('name', 'id')),
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
                    ->required(),
                Toggle::make('is_featured')
                    ->label(__('Is Featured'))
                    ->required(),
            ]);
    }
}
