<?php

namespace Herisvanhendra\Pos\Services;

use Herisvanhendra\Pos\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    /**
     * Get all categories with product count - optimized
     */
    public function getAllCategories()
    {
        return Category::withCount('products')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get paginated categories
     */
    public function getCategoriesPaginated(int $perPage = 10)
    {
        return Category::withCount('products')
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get category by ID with products - avoids N+1
     */
    public function getCategoryWithProducts(int $id)
    {
        return Category::with(['products' => function ($query) {
            $query->select('id', 'name', 'price', 'stock', 'category_id');
        }])->findOrFail($id);
    }

    /**
     * Create new category
     */
    public function createCategory(array $data): Category
    {
        $category = Category::create($data);
        Cache::forget('categories_list');
        return $category;
    }

    /**
     * Update category
     */
    public function updateCategory(int $id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        Cache::forget('categories_list');
        return $category;
    }

    /**
     * Delete category
     */
    public function deleteCategory(int $id): bool
    {
        $category = Category::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return false;
        }
        
        $result = $category->delete();
        Cache::forget('categories_list');
        return $result;
    }

    /**
     * Get categories for dropdown - cached
     */
    public function getCategoriesForDropdown()
    {
        return Cache::remember('categories_list', 3600, function () {
            return Category::orderBy('name')->get(['id', 'name']);
        });
    }
}

