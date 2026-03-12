<?php

namespace Herisvanhendra\Pos\Services;

use Herisvanhendra\Pos\Models\Sale;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getAllSales(int $perPage = 15)
    {
        return Sale::with(['user:id,name'])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getDailyReport(string $date)
    {
        $startOfDay = $date . ' 00:00:00';
        $endOfDay = $date . ' 23:59:59';

        $sales = Sale::with(['user:id,name'])
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = Sale::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('status', 'completed')
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->first();

        return [
            'sales' => $sales,
            'total_revenue' => $stats->total_revenue ?? 0,
            'total_transactions' => $stats->total_transactions ?? 0,
        ];
    }

    public function getMonthlyReport(string $month)
    {
        $year = date('Y', strtotime($month));
        $monthNum = date('m', strtotime($month));

        $startOfMonth = "{$year}-{$monthNum}-01 00:00:00";
        $endOfMonth = date('Y-m-t 23:59:59', strtotime($month . '-01'));

        $sales = Sale::with(['user:id,name'])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'completed')
            ->select(
                DB::raw('COUNT(*) as total_transactions'),
                DB::raw('SUM(total_amount) as total_revenue')
            )
            ->first();

        return [
            'sales' => $sales,
            'total_revenue' => $stats->total_revenue ?? 0,
            'total_transactions' => $stats->total_transactions ?? 0,
        ];
    }

    public function getTopSellingProducts(string $startDate, string $endDate, int $limit = 10)
    {
        return DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('sale_items.created_at', [$startDate, $endDate])
            ->select(
                'products.id',
                'products.name',
                'categories.name as category_name',
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.subtotal) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'categories.name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();
    }

    public function getDailySummary(string $startDate, string $endDate)
    {
        return Sale::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as transactions'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
    }

    public function getSalesByCategory(string $startDate, string $endDate)
    {
        return DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('sale_items.created_at', [$startDate, $endDate])
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.subtotal) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_revenue')
            ->get();
    }
}

