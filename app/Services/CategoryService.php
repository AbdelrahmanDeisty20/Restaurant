<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryService
{
    public function getAllCategories()
    {
        $categories = Category::paginate(10);

        if ($categories->isEmpty()) {
            return [
                'status' => false,
                'message' => __('messages.no_categories_found'),
                'data' => [],
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.categories_retrieved_successfully'),
            'data' => CategoryResource::collection($categories),
        ];
    }

    public function getCategoryById($id)
    {
        $category = Category::with('products.offers')->find($id);

        if (!$category) {
            return [
                'status' => false,
                'message' => __('messages.category_not_found'),
                'data' => [],
            ];
        }

        return [
            'status' => true,
            'message' => __('messages.category_retrieved_successfully'),
            'data' => new CategoryResource($category),
        ];
    }
}
