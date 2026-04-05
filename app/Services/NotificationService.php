<?php

namespace App\Services;

use App\Models\UserFcmToken;
use App\Services\FirebaseNotificationService;

class NotificationService
{
    protected $firebaseService;

    public function __construct(FirebaseNotificationService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

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

    public function sendNotificationToGuests($title, $body, $data = [])
    {
        $tokens = UserFcmToken::whereNull('user_id')->pluck('fcm_token')->toArray();

        $results = [];
        foreach ($tokens as $token) {
            $results[] = $this->firebaseService->sendToToken($token, $title, $body, $data);
        }

        return [
            'status' => true,
            'message' => 'Test notifications sent to all guest tokens',
            'count' => count($tokens),
            'details' => $results,
        ];
    }
}