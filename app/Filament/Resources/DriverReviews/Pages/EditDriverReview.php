<?php

namespace App\Filament\Resources\DriverReviews\Pages;

use App\Filament\Resources\DriverReviews\DriverReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDriverReview extends EditRecord
{
    protected static string $resource = DriverReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
