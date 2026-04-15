<?php

namespace App\Filament\Exports;

use App\Models\Product;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ProductExporter extends Exporter
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name_ar')
                ->label(__('Name (Arabic)')),
            ExportColumn::make('name_en')
                ->label(__('Name (English)')),
            ExportColumn::make('description_ar')
                ->label(__('Description (Arabic)')),
            ExportColumn::make('description_en')
                ->label(__('Description (English)')),
            ExportColumn::make('main_image')
                ->label(__('Main Image')),
            ExportColumn::make('price')
                ->label(__('Price')),
            ExportColumn::make('discount_price')
                ->label(__('Discount Price')),
            ExportColumn::make('category.name')
                ->label(__('Category')),
            ExportColumn::make('category_id')
                ->label(__('Category ID')),
            ExportColumn::make('is_active')
                ->label(__('Active')),
            ExportColumn::make('is_featured')
                ->label(__('Featured')),
            ExportColumn::make('time')
                ->label(__('Preparation Time')),
            ExportColumn::make('sizes')
                ->label(__('Sizes (AR|EN|Price)'))
                ->state(function (Product $record): string {
                    return $record->sizes->map(function ($size) {
                        return "{$size->name_ar}|{$size->name_en}|{$size->price}";
                    })->implode('; ');
                }),
            ExportColumn::make('extras')
                ->label(__('Extras'))
                ->state(function (Product $record): string {
                    if (empty($record->included_extras)) {
                        return '';
                    }
                    return \App\Models\ProductExtra::whereIn('id', $record->included_extras)
                        ->pluck('name_ar')
                        ->implode(', ');
                }),
            ExportColumn::make('created_at')
                ->label(__('Created At')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your product export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
