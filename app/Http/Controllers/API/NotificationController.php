<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\storeTokenRequest;
use App\Services\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function sendToken(storeTokenRequest $request)
    {
        $result = $this->notificationService->sendToken($request->all());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success([], $result['message']);
    }

    public function sendTestNotification(Request $request)
    {
        $title = $request->title ?? __('messages.test_notification_guest_title');
        $body = $request->body ?? __('messages.test_notification_guest_body');
        $data = $request->data ?? ['type' => 'test'];

        $result = $this->notificationService->sendNotificationToGuests($title, $body, $data);

        return $this->success($result, $result['message']);
    }

    public function sendTestNotificationToUsers(Request $request)
    {
        $title = $request->title ?? __('messages.test_notification_user_title');
        $body = $request->body ?? __('messages.test_notification_user_body');
        $data = $request->data ?? ['type' => 'test_user'];

        $result = $this->notificationService->sendNotificationToUsers($title, $body, $data);

        return $this->success($result, $result['message']);
    }

    public function index()
    {
        $result = $this->notificationService->notifications();
        
        if (!$result['status']) {
            return $this->success([], $result['message']);
        }

        return $this->success($result['data'], $result['message']);
    }

    public function markAsRead($id)
    {
        $result = $this->notificationService->markAsRead($id);

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success([], $result['message']);
    }
}
