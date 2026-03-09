<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderTrackingResource;
use App\Services\OrderTrackingService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    use ApiResponse;

    protected $trackingService;

    public function __construct(OrderTrackingService $trackingService)
    {
        $this->trackingService = $trackingService;
    }

    /**
     * Get tracking information for an order.
     */
    public function show(Request $request, $id)
    {
        $result = $this->trackingService->getTrackingInfo($id, $request->user()->id);

        if (!$result['status']) {
            return $this->error($result['message'], 404);
        }

        return $this->success(new OrderTrackingResource($result['data']), $result['message']);
    }

    /**
     * Update driver location (Mock for now, would be in Driver API normally).
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $success = $this->trackingService->updateDriverLocation(
            $request->driver_id,
            $request->lat,
            $request->lng
        );

        if (!$success) {
            return $this->error('Failed to update location', 400);
        }

        return $this->messageOnly('Location updated successfully');
    }
}
