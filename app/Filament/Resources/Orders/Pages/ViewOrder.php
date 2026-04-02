<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('changeStatus')
                ->label(__('Change Status'))
                ->icon('heroicon-m-arrow-path')
                ->form([
                    \Filament\Forms\Components\Select::make('status')
                        ->label(__('Status'))
                        ->options([
                            'pending' => __('Pending'),
                            'accepted' => __('Accepted'),
                            'on_the_way' => __('On the way'),
                            'delivered' => __('Delivered'),
                            'cancelled' => __('Cancelled'),
                        ])
                        ->required()
                        ->default(fn ($record) => $record->status),
                ])
                ->action(function (array $data, $record): void {
                    $record->update([
                        'status' => $data['status'],
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title(__('Status updated successfully'))
                        ->success()
                        ->send();
                }),
            EditAction::make(),
        ];
    }
}
