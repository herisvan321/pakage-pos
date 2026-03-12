<?php

namespace Herisvanhendra\Pos\Services;

use Herisvanhendra\Pos\Models\Sale;
use Herisvanhendra\Pos\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStatistics(): array
    {
        $todayRevenue = Sale::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total_amount');

        $todayTransactions = Sale::whereDate('created_at', today())
            ->where('status', 'completed')
            ->count();

        $monthRevenue = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('total_amount');

        $monthTransactions = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->count();

        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->count();

        $recentSales = Sale::with(['user:id,name'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        return [
            'today_revenue' => $todayRevenue,
            'today_transactions' => $todayTransactions,
            'month_revenue' => $monthRevenue,
            'month_transactions' => $monthTransactions,
            'total_products' => $totalProducts,
            'low_stock_products' => $lowStockProducts,
            'recent_sales' => $recentSales,
            'top_products' => $topProducts,
        ];
    }

    public function getWeeklyChartData(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        
        $dailySales = Sale::where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as transactions'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $revenues = [];
        $transactions = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d M');
            
            $dayData = $dailySales->get($date);
            $revenues[] = $dayData ? $dayData->revenue : 0;
            $transactions[] = $dayData ? $dayData->transactions : 0;
        }

        return [
            'labels' => $labels,
            'revenues' => $revenues,
            'transactions' => $transactions,
        ];
    }
}

