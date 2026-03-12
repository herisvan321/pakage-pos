<?php

namespace Herisvanhendra\Pos\Http\Controllers;

use Illuminate\Http\Request;
use Herisvanhendra\Pos\Services\SaleService;
use Herisvanhendra\Pos\Services\ProductService;

class SaleController extends Controller
{
    protected SaleService $saleService;
    protected ProductService $productService;

    public function __construct(SaleService $saleService, ProductService $productService)
    {
        $this->saleService = $saleService;
        $this->productService = $productService;
    }

    public function index()
    {
        $sales = $this->saleService->getAllSales(15);
        return view('pos::sales.index', compact('sales'));
    }

    public function create()
    {
        $products = $this->productService->getProductsForSale();
        return view('pos::sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            $sale = $this->saleService->createSale($validated['items'], auth()->id());
            return redirect()->route('pos.sales.show', $sale->id)
                ->with('success', 'Penjualan berhasil disimpan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(int $id)
    {
        $sale = $this->saleService->getSaleById($id);
        return view('pos::sales.show', compact('sale'));
    }

    public function destroy(int $id)
    {
        try {
            $this->saleService->cancelSale($id);
            return redirect()->route('pos.sales.index')
                ->with('success', 'Penjualan berhasil dibatalkan');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

