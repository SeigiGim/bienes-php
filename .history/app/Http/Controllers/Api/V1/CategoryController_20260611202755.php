<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $categoryService) {}

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $category = $this->categoryService->store($request->validated());

        return response()->json([
            'message' => 'Category created successfully.',
            'data' => $category,
        ], 201);
    }
}
