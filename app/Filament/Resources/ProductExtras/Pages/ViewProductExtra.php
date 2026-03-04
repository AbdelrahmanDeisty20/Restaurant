<?php

namespace App\Filament\Resources\ProductExtras\Pages;

use App\Filament\Resources\ProductExtras\ProductExtraResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProductExtra extends ViewRecord
{
    protected static string $resource = ProductExtraResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
