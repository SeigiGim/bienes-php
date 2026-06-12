<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $categoryService) {}

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->store($request->validated());

        return new CategoryResource($category);
    }

    public function index()
    {
        $categories = $this->categoryService->all();
    }
}
