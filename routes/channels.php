<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('order.{orderId}', function ($user, $orderId) {
    $order = \App\Models\Order::find($orderId);
    if (!$order) return false;
    
    // يفتح للعميل صاحب الطلب أو السائق المكلف بالطلب
    return (int) $user->id === (int) $order->user_id || (int) $user->id === (int) $order->driver_id;
});
