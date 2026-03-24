<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_ar')
                    ->label(__('Name AR'))
                    ->nullable(),
                TextInput::make('name_en')
                    ->label(__('Name EN'))
                    ->nullable(),
                FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->directory('categories')
                    ->nullable()
                    ->downloadable(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
            ]);
    }
}