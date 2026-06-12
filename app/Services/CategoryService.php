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

    public function find(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->find($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->find($id);
        $category->delete();
    }
}
