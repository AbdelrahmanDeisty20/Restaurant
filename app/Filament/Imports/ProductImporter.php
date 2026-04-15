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
                ->rules(['nullable']),
            ImportColumn::make('description_en')
                ->label(__('Description (English)'))
                ->rules(['nullable']),
            ImportColumn::make('price')
                ->label(__('Price'))
                ->numeric()
                ->rules(['nullable', 'numeric', 'min:0']),
            ImportColumn::make('discount_price')
                ->label(__('Discount Price'))
                ->numeric()
                ->rules(['numeric', 'nullable', 'min:0']),
            ImportColumn::make('category')
                ->label(__('Category'))
                ->requiredMapping()
                ->relationship(resolveUsing: function (string $state): ?int {
                    return \App\Models\Category::query()
                        ->where('name_ar', $state)
                        ->orWhere('name_en', $state)
                        ->first()
                        ?->id;
                })
                ->rules(['required']),
            ImportColumn::make('main_image')
                ->label(__('Main Image'))
                ->rules(['nullable']),
            ImportColumn::make('is_active')
                ->label(__('Active'))
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('is_featured')
                ->label(__('Featured'))
                ->boolean()
                ->rules(['boolean']),
            ImportColumn::make('time')
                ->label(__('Preparation Time'))
                ->numeric(),
            ImportColumn::make('sizes')
                ->label(__('Sizes (AR|EN|Price;...)'))
                ->rules(['nullable']),
            ImportColumn::make('extras')
                ->label(__('Extras (Comma separated)'))
                ->rules(['nullable']),
        ];
    }

    public function resolveRecord(): Product
    {
        $product = null;
        if ($this->options['updateExisting'] ?? false) {
             $product = Product::firstOrNew([
                 'name_en' => $this->data['name_en'],
             ]);
        } else {
            $product = new Product();
        }

        $product->is_active = $this->data['is_active'] ?? true;
        $product->is_featured = $this->data['is_featured'] ?? false;

        return $product;
    }

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        $data = $this->data;

        // 1. Handle Sizes (Format: Name AR|Name EN|Price; ...)
        if (!empty($data['sizes'])) {
            $record->sizes()->delete(); 
            $sizes = explode(';', $data['sizes']);
            foreach ($sizes as $sizeStr) {
                $parts = explode('|', $sizeStr);
                if (count($parts) === 3) {
                    $record->sizes()->create([
                        'name_ar' => trim($parts[0]),
                        'name_en' => trim($parts[1]),
                        'price' => (float) trim($parts[2]),
                    ]);
                }
            }
        }

        // 2. Handle Extras (Format: Name1, Name2, ...)
        if (!empty($data['extras'])) {
            $extrasNames = explode(',', $data['extras']);
            $extrasIds = \App\Models\ProductExtra::query()
                ->whereIn('name_ar', array_map('trim', $extrasNames))
                ->orWhereIn('name_en', array_map('trim', $extrasNames))
                ->pluck('id')
                ->toArray();
            
            $record->update(['included_extras' => $extrasIds]);
        }
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
