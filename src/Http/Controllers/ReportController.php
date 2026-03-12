<?php

namespace Herisvanhendra\Pos\Http\Controllers;

use Illuminate\Http\Request;
use Herisvanhendra\Pos\Services\ReportService;
use Herisvanhendra\Pos\Services\SaleService;

class ReportController extends Controller
{
    protected ReportService $reportService;
    protected SaleService $saleService;

    public function __construct(ReportService $reportService, SaleService $saleService)
    {
        $this->reportService = $reportService;
        $this->saleService = $saleService;
    }

    public function index()
    {
        $sales = $this->reportService->getAllSales(15);
        return view('pos::reports.index', compact('sales'));
    }

    public function daily(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $report = $this->reportService->getDailyReport($date);

        return view('pos::reports.daily', [
            'sales' => $report['sales'],
            'totalRevenue' => $report['total_revenue'],
            'totalTransactions' => $report['total_transactions'],
            'date' => $date,
        ]);
    }

    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $report = $this->reportService->getMonthlyReport($month);

        return view('pos::reports.monthly', [
            'sales' => $report['sales'],
            'totalRevenue' => $report['total_revenue'],
            'totalTransactions' => $report['total_transactions'],
            'month' => $month,
        ]);
    }
}

