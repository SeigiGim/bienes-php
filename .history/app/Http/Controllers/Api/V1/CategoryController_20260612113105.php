<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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

    public function index(): AnonymousResourceCollection
    {
        $categories = $this->categoryService->all();

        return CategoryResource::collection($categories);
    }

    public function show(int $id): CategoryResource
    {
        $category = $this->categoryService->find($id);

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, int $id): CategoryResource
    {
        $category = $this->categoryService->update($id, $request->validated());

        return new CategoryResource($category);
    }

    public function destroy(int $id)
    {
        $this->categoryService->delete($id);

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
