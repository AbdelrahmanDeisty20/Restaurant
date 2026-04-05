<?php

namespace App\Services;

class NotificationService
{
    public function sendToken(array $data)
    {
        $userId = $data['user_id'] ?? auth()->id();

        $token = \App\Models\UserFcmToken::updateOrCreate(
            [
                'device_id' => $data['device_id'] ?? null,
                'user_id' => $userId,
            ],
            [
                'fcm_token' => $data['fcm_token'],
            ]
        );

        return [
            'status' => true,
            'message' => __('messages.fcm_token_stored_successfully'),
            'data' => $token,
        ];
    }
}