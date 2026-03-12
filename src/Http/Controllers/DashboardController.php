<?php

namespace Herisvanhendra\Pos\Http\Controllers;

use Herisvanhendra\Pos\Services\DashboardService;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $stats = $this->dashboardService->getStatistics();
        $chartData = $this->dashboardService->getWeeklyChartData();

        return view('pos::dashboard', array_merge($stats, ['chartData' => $chartData]));
    }
}

