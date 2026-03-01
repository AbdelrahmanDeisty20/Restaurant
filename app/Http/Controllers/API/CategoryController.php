<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        if (!$categories['status']) {
            return $this->error($categories['message'], 404);
        }
        $message = __('messages.categories_retrieved_successfully');
        return $this->paginated(CategoryResource::class, $categories['data'], $message);
    }
    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        if (!$category['status']) {
            return $this->error($category['message'], 404);
        }
        $message = __('messages.category_retrieved_successfully');
        return $this->success(new CategoryResource($category['data']), $message);
    }
}
