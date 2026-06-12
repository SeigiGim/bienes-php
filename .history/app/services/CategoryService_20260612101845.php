<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function store(array $data): Category
    {
        return Category::create($data);
    }

    public function all(): Collection
    {
        return Category::all();
    }

    public function find($id): Category
    {
        return Category::findOrFail($id);
    }
}
