<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function store(array $data): Category
    {
        return Category::create($data);
    }
}
