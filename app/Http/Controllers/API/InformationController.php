<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Services\InformationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    use ApiResponse;

    protected $infoService;

    public function __construct(InformationService $infoService)
    {
        $this->infoService = $infoService;
    }

    public function pages()
    {
        $pages = $this->infoService->getPages();
        return $this->success(PageResource::collection($pages));
    }

    public function page($slug)
    {
        $page = $this->infoService->getPageBySlug($slug);
        if (!$page) {
            return $this->notFound(__('messages.page_not_found'));
        }
        return $this->success(new PageResource($page));
    }

    public function settings()
    {
        $result = $this->infoService->getSettings();
        return $this->success($result['data'], $result['message']);
    }
}
