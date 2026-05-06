<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService)
    {
    }

    public function index(): View
    {
        return view('pages.dashboard.index', [
            'metrics' => $this->dashboardService->metrics(),
            'charts' => $this->dashboardService->charts(),
            'activities' => $this->dashboardService->recentActivities(),
        ]);
    }
}
