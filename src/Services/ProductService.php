<?php

namespace Herisvanhendra\Pos\Services;

use Herisvanhendra\Pos\Models\Product;

class ProductService
{
    public function getAllProducts()
    {
        return Product::with('category:id,name')
            ->orderBy('name')
            ->get();
    }

    public function getProductsPaginated(int $perPage = 10)
    {
        return Product::with('category:id,name')
            ->orderBy('name')
            ->paginate($perPage);
    }

    public function getProductsForSale()
    {
        return Product::with('category:id,name')
            ->where('stock', '>', 0)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'stock', 'category_id']);
    }

    public function getProductById(int $id)
    {
        return Product::with('category:id,name')
            ->findOrFail($id);
    }

    public function searchProductsForSale(string $search)
    {
        return Product::with('category:id,name')
            ->where('stock', '>', 0)
            ->where('name', 'like', "%{$search}%")
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'price', 'stock', 'category_id']);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product->fresh('category:id,name');
    }

    public function deleteProduct(int $id): bool
    {
        $product = Product::findOrFail($id);
        return $product->delete();
    }

    public function updateStock(int $id, int $quantity): Product
    {
        $product = Product::findOrFail($id);
        $product->decrement('stock', $quantity);
        return $product->fresh('category:id,name');
    }

    public function bulkUpdateStock(array $items): void
    {
        foreach ($items as $item) {
            Product::where('id', $item['product_id'])
                ->increment('stock', $item['quantity']);
        }
    }

    public function getLowStockProducts(int $threshold = 10)
    {
        return Product::with('category:id,name')
            ->where('stock', '<=', $threshold)
            ->orderBy('stock', 'asc')
            ->get();
    }

    public function getProductsByCategory(int $categoryId)
    {
        return Product::with('category:id,name')
            ->where('category_id', $categoryId)
            ->orderBy('name')
            ->get();
    }
}

