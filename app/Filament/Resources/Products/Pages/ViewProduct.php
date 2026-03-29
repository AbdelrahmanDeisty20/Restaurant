<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['name_ar'] = $this->record->name_ar;
        $data['name_en'] = $this->record->name_en;
        $data['description_ar'] = $this->record->description_ar;
        $data['description_en'] = $this->record->description_en;
        $data['image_path'] = $this->record->main_image;

        return $data;
    }
}
