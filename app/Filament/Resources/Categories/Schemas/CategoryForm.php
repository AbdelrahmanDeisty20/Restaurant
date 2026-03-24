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
        $locale = app()->getLocale();
        $otherLocale = $locale === 'ar' ? 'en' : 'ar';

        return $schema
            ->components([
                TextInput::make("name_{$locale}")
                    ->label($locale === 'ar' ? __('Name AR') : __('Name EN'))
                    ->nullable(),
                TextInput::make("name_{$otherLocale}")
                    ->label($otherLocale === 'ar' ? __('Name AR') : __('Name EN'))
                    ->nullable(),
                FileUpload::make('image')
                    ->label(__('Image'))
                    ->image()
                    ->directory('categories')
                    ->nullable(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->default(true),
            ]);
    }
}