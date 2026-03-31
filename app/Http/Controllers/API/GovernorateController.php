<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\GovernorateService;
use App\Traits\ApiResponse;

class GovernorateController extends Controller
{
    use ApiResponse;
    protected $governorateService;
    public function __construct(GovernorateService $governorateService){
        $this->governorateService = $governorateService;
    }
    public function index(){
        $governorates = $this->governorateService->getAll();
        if(!$governorates['status']){
            return $this->error($governorates['message'], 404);
        }
        $message = __('messages.governorates_retrieved_successfully');
        return $this->success($governorates['data'], $message);
    }
}
