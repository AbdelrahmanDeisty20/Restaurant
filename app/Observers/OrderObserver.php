<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\AppNotification;
use App\Models\User;
use App\Services\NotificationService;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class OrderObserver
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $admins = User::role(['super_admin', 'admin'])->get();
        $userName = $order->user?->full_name ?? __('Guest');

        Notification::make()
            ->title(__('New Order Received'))
            ->body(__('Order #:order_number from :name', [
                'order_number' => $order->order_number,
                'name' => $userName,
            ]))
            ->icon('heroicon-o-shopping-bag')
            ->iconColor('success')
            ->actions([
                Action::make('view')
                    ->label(__('View Order'))
                    ->url(fn (): string => \App\Filament\Resources\Orders\OrderResource::getUrl('view', ['record' => $order->id])),
            ])
            ->sendToDatabase($admins);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->isDirty('status')) {
            $status = $order->status;
            $orderNumber = $order->order_number;
            
            $allowedStatuses = ['preparing', 'on_the_way', 'cancelled'];
            
            if (in_array($status, $allowedStatuses)) {
                $titleKey = "messages.order_status_{$status}_title";
                $bodyKey = "messages.order_status_{$status}_body";
                
                $this->notificationService->sendToUser(
                    $order->user_id,
                    __($titleKey),
                    __($bodyKey, ['order_number' => $orderNumber]),
                    [
                        'type' => 'order_status_update',
                        'order_id' => $order->id,
                        'status' => $status,
                    ]
                );

                // Save notification to database
                AppNotification::create([
                    'user_id' => $order->user_id,
                    'title' => __($titleKey),
                    'body' => __($bodyKey, ['order_number' => $orderNumber]),
                    'type' => 'order_status_update',
                    'data' => [
                        'order_id' => $order->id,
                        'status' => $status,
                    ],
                ]);
            }
        }
    }
}
