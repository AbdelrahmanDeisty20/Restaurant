<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
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
                    ->required(),
                TextInput::make('name_en')
                    ->required(),
                Textarea::make('description_ar')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description_en')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('main_image')
                    ->image()
                    ->required(),
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
            ]);
    }
}
