<?php

namespace Herisvanhendra\Pos\Http\Controllers;

use Illuminate\Http\Request;
use Herisvanhendra\Pos\Services\CategoryService;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getCategoriesPaginated(10);
        return view('pos::categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pos::categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->categoryService->createCategory($data);

        return redirect()->route('pos.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function show(int $id)
    {
        $category = $this->categoryService->getCategoryWithProducts($id);
        return view('pos::categories.show', compact('category'));
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->getCategoryWithProducts($id);
        return view('pos::categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $this->categoryService->updateCategory($id, $data);

        return redirect()->route('pos.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(int $id)
    {
        $deleted = $this->categoryService->deleteCategory($id);

        if (!$deleted) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk');
        }

        return redirect()->route('pos.categories.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}

