<?php

namespace App\Services;

use App\Models\Driver;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;

class OrderTrackingService
{
    /**
     * Get full tracking data for an order.
     */
    public function getTrackingInfo(int $orderId, int $userId)
    {
        $order = Order::with(['driver', 'statusHistories', 'items'])
            ->where('id', $orderId)
            ->where('user_id', $userId)
            ->first();

        if (!$order) {
            return [
                'status' => false,
                'message' => __('messages.order_not_found'),
                'data' => null
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.success'),
            'data' => $order
        ];
    }

    /**
     * Update order status and log history.
     */
    public function updateStatus(int $orderId, string $status, ?string $notes = null)
    {
        return DB::transaction(function () use ($orderId, $status, $notes) {
            $order = Order::find($orderId);
            if (!$order)
                return false;

            $order->update(['status' => $status]);

            $order->statusHistories()->create([
                'status' => $status,
                'notes' => $notes
            ]);

            // If status is out_for_delivery, maybe pick a driver if not assigned?
            // Broadcast event here...

            return true;
        });
    }

    /**
     * Update driver location for real-time tracking.
     */
    public function updateDriverLocation(int $driverId, float $lat, float $lng)
    {
        $driver = \App\Models\Driver::find($driverId);
        if (!$driver)
            return false;

        $driver->update([
            'current_lat' => $lat,
            'current_lng' => $lng,
        ]);

        // Find active orders for this driver to broadcast
        $orders = \App\Models\Order::where('driver_id', $driverId)
            ->whereIn('status', ['preparing', 'on_the_way'])
            ->get();

        foreach ($orders as $order) {
            broadcast(new \App\Events\DriverLocationUpdated($order->id, $lat, $lng));
        }

        return true;
    }
}
