<?php
namespace App\Services;

use App\Http\Resources\GovernorateResource;
use App\Models\Governorate;

class GovernorateService
{
    public function getAll(){
        $governorates = Governorate::all();
        if($governorates->isEmpty()){
            return [
                'status' => false,
                'message' => __('messages.no_governorates_found'),
                'data' => [],
            ];
        }
        return [
            'status' => true,
            'message' => __('messages.governorates_retrieved_successfully'),
            'data' => GovernorateResource::collection($governorates),
        ];
    }
}