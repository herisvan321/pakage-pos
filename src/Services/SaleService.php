<?php

namespace Herisvanhendra\Pos\Services;

use Herisvanhendra\Pos\Models\Sale;
use Herisvanhendra\Pos\Models\SaleItem;
use Herisvanhendra\Pos\Models\Product;
use Illuminate\Support\Facades\DB;

class SaleService
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAllSales(int $perPage = 15)
    {
        return Sale::with(['user:id,name'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getSaleById(int $id)
    {
        return Sale::with([
            'user:id,name',
            'items.product:id,name,price'
        ])->findOrFail($id);
    }

    public function createSale(array $items, int $userId): Sale
    {
        return DB::transaction(function () use ($items, $userId) {
            $totalAmount = 0;
            $saleItems = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak cukup");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $saleItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ];

                $product->decrement('stock', $item['quantity']);
            }

            $sale = Sale::create([
                'user_id' => $userId,
                'total_amount' => $totalAmount,
                'status' => 'completed',
            ]);

            SaleItem::insert($saleItems);

            return $sale->load(['user:id,name', 'items.product:id,name,price']);
        });
    }

    public function cancelSale(int $id): Sale
    {
        return DB::transaction(function () use ($id) {
            $sale = Sale::with('items')->findOrFail($id);

            if ($sale->status === 'cancelled') {
                throw new \Exception('Sale already cancelled');
            }

            foreach ($sale->items as $item) {
                Product::where('id', $item['product_id'])
                    ->increment('stock', $item['quantity']);
            }

            $sale->update(['status' => 'cancelled']);

            return $sale->fresh(['user:id,name', 'items.product:id,name,price']);
        });
    }

    public function getTodaySales()
    {
        return Sale::with(['user:id,name'])
            ->whereDate('created_at', today())
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSalesByDateRange(string $startDate, string $endDate)
    {
        return Sale::with(['user:id,name'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getSalesStats(string $startDate, string $endDate): array
    {
        $stats = Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->first();

        return [
            'total_transactions' => $stats->total_transactions ?? 0,
            'total_revenue' => $stats->total_revenue ?? 0,
        ];
    }
}

