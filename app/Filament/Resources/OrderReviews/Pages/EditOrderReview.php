<?php

namespace App\Filament\Resources\OrderReviews\Pages;

use App\Filament\Resources\OrderReviews\OrderReviewResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrderReview extends EditRecord
{
    protected static string $resource = OrderReviewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
