<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckoutRequest;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;

    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function checkout(CheckoutRequest $request)
    {
        $result = $this->orderService->checkout($request->user()->id, $request->validated());

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }
}
