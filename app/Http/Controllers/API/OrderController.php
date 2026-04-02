<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckoutRequest;
use App\Http\Requests\API\OrderSearchRequest;
use App\Http\Resources\OrderResource;
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

        return $this->success($result['data'], $result['message'], 201);
    }

    public function index(Request $request)
    {
        $result = $this->orderService->getOrders($request->user()->id);

        return $this->success($result['data'], $result['message']);
    }

    public function show(Request $request, $id)
    {
        $result = $this->orderService->getOrder($request->user()->id, $id);

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success($result['data'], $result['message']);
    }

    public function search(OrderSearchRequest $request)
    {
        $result = $this->orderService->searchOrders($request->user()->id, $request->search);

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->paginated(OrderResource::class, $result['data'], $result['message']);
    }

    public function cancel(Request $request, $id)
    {
        $result = $this->orderService->cancelOrder($request->user()->id, $id);

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }

    public function delete(Request $request, $id)
    {
        $result = $this->orderService->deleteOrder($request->user()->id, $id);

        if (!$result['status']) {
            return $this->error($result['message'], 400);
        }

        return $this->success($result['data'], $result['message']);
    }
}
