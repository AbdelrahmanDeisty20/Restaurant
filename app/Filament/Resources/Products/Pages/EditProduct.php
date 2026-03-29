<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeFill(array $data): array
    // {
    //     $data['name_ar'] = $this->record->name_ar;
    //     $data['name_en'] = $this->record->name_en;
    //     $data['description_ar'] = $this->record->description_ar;
    //     $data['description_en'] = $this->record->description_en;
    //     $data['main_image'] = $this->record->main_image;

    //     return $data;
    // }
}
