<?php

namespace Herisvanhendra\Pos\Http\Controllers;

use Illuminate\Http\Request;
use Herisvanhendra\Pos\Services\ProductService;
use Herisvanhendra\Pos\Services\CategoryService;

class ProductController extends Controller
{
    protected ProductService $productService;
    protected CategoryService $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $products = $this->productService->getProductsPaginated(10);
        return view('pos::products.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categoryService->getCategoriesForDropdown();
        return view('pos::products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $this->productService->createProduct($data);

        return redirect()->route('pos.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(int $id)
    {
        $product = $this->productService->getProductById($id);
        return view('pos::products.show', compact('product'));
    }

    public function edit(int $id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->categoryService->getCategoriesForDropdown();
        return view('pos::products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $this->productService->updateProduct($id, $data);

        return redirect()->route('pos.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        $this->productService->deleteProduct($id);

        return redirect()->route('pos.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}

