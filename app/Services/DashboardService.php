<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Lead;

class DashboardService
{
    public function metrics(): array
    {
        $leadCount = Lead::count();
        $qualifiedCount = Lead::where('status', 'qualified')->count();

        return [
            'total_leads' => $leadCount,
            'total_customers' => Customer::count(),
            'revenue' => Deal::where('stage', 'closed')->sum('amount'),
            'conversion_rate' => $leadCount > 0 ? round(($qualifiedCount / $leadCount) * 100, 1) : 0,
        ];
    }

    public function charts(): array
    {
        return [
            'salesOverview' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'datasets' => [
                    [
                        'label' => 'Revenue',
                        'data' => [18000, 25000, 22000, 36000, 41000, 48000],
                    ],
                ],
            ],
            'leadConversion' => [
                'labels' => ['New', 'Contacted', 'Qualified', 'Lost'],
                'datasets' => [
                    [
                        'label' => 'Leads',
                        'data' => [
                            Lead::where('status', 'new')->count(),
                            Lead::where('status', 'contacted')->count(),
                            Lead::where('status', 'qualified')->count(),
                            Lead::where('status', 'lost')->count(),
                        ],
                    ],
                ],
            ],
        ];
    }

    public function recentActivities(int $limit = 8)
    {
        return Activity::query()
            ->with('user')
            ->latest('occurred_at')
            ->limit($limit)
            ->get();
    }
}
