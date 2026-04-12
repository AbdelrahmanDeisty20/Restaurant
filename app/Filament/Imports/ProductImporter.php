<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name_ar')
                ->label(__('Name (Arabic)'))
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name_en')
                ->label(__('Name (English)'))
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('description_ar')
                ->label(__('Description (Arabic)'))
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('description_en')
                ->label(__('Description (English)'))
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('price')
                ->label(__('Price'))
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric']),
            ImportColumn::make('discount_price')
                ->label(__('Discount Price'))
                ->numeric()
                ->rules(['numeric', 'nullable']),
            ImportColumn::make('category_id')
                ->label(__('Category ID'))
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer', 'exists:categories,id']),
            ImportColumn::make('is_active')
                ->label(__('Active'))
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('is_featured')
                ->label(__('Featured'))
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
            ImportColumn::make('time')
                ->label(__('Preparation Time')),
        ];
    }

    public function resolveRecord(): Product
    {
        if ($this->options['updateExisting'] ?? false) {
             return Product::firstOrNew([
                 'name_en' => $this->data['name_en'],
             ]);
        }

        return new Product();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
