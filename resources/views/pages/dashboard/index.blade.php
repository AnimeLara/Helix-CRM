@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <section class="crm-page-header">
            <div class="crm-page-header-content">
                <div class="max-w-3xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-600 dark:text-teal-300">Revenue cockpit</p>
                    <h2 class="crm-heading mt-3 text-3xl sm:text-4xl">Your pipeline, team activity, and customer growth in one polished view.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">
                        Keep conversion momentum visible, spot blockers faster, and operate the CRM like a premium SaaS workspace instead of a basic admin panel.
                    </p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 xl:min-w-[420px]">
                    <div class="rounded-[24px] border border-white/80 bg-white/70 px-4 py-4 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Active reps</p>
                        <p class="mt-2 font-display text-2xl font-bold text-slate-950 dark:text-white">03</p>
                    </div>
                    <div class="rounded-[24px] border border-white/80 bg-white/70 px-4 py-4 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Open deals</p>
                        <p class="mt-2 font-display text-2xl font-bold text-slate-950 dark:text-white">14</p>
                    </div>
                    <div class="rounded-[24px] border border-white/80 bg-white/70 px-4 py-4 shadow-sm backdrop-blur dark:border-slate-700 dark:bg-slate-900/70">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Health score</p>
                        <p class="mt-2 font-display text-2xl font-bold text-slate-950 dark:text-white">8.7</p>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-5 md:grid-cols-2 2xl:grid-cols-4">
            <x-ui.card class="crm-stat-card">
                <p class="crm-subtext">Total Leads</p>
                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <p class="crm-heading text-4xl">{{ $metrics['total_leads'] }}</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Fresh top-of-funnel demand</p>
                    </div>
                    <x-ui.badge tone="amber">+12.4%</x-ui.badge>
                </div>
            </x-ui.card>
            <x-ui.card class="crm-stat-card">
                <p class="crm-subtext">Total Customers</p>
                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <p class="crm-heading text-4xl">{{ $metrics['total_customers'] }}</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Accounts currently managed</p>
                    </div>
                    <x-ui.badge tone="sky">+8.1%</x-ui.badge>
                </div>
            </x-ui.card>
            <x-ui.card class="crm-stat-card">
                <p class="crm-subtext">Revenue</p>
                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <p class="crm-heading text-4xl">${{ number_format($metrics['revenue'], 0) }}</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Closed-won value</p>
                    </div>
                    <x-ui.badge tone="emerald">Closed won</x-ui.badge>
                </div>
            </x-ui.card>
            <x-ui.card class="crm-stat-card">
                <p class="crm-subtext">Conversion Rate</p>
                <div class="mt-5 flex items-end justify-between">
                    <div>
                        <p class="crm-heading text-4xl">{{ $metrics['conversion_rate'] }}%</p>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Qualified lead efficiency</p>
                    </div>
                    <x-ui.badge tone="violet">Pipeline quality</x-ui.badge>
                </div>
            </x-ui.card>
        </div>

        <div class="grid gap-6 xl:grid-cols-[1.35fr_0.95fr]">
            <x-ui.card title="Sales Overview" subtitle="Monthly revenue trend across the active pipeline.">
                <div class="rounded-[24px] bg-slate-50/70 p-4 dark:bg-slate-950/40">
                    <canvas id="sales-overview-chart" height="140"></canvas>
                </div>
            </x-ui.card>

            <x-ui.card title="Recent Activity" subtitle="Live workspace updates from your team and customer touchpoints.">
                <div class="space-y-4">
                    @foreach ($activities as $activity)
                        <div class="flex gap-4 rounded-[22px] border border-slate-200/70 bg-slate-50/70 p-4 dark:border-slate-800/80 dark:bg-slate-950/40">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white text-slate-700 shadow-sm dark:bg-slate-800 dark:text-slate-200">
                                <i data-lucide="{{ $activity->icon }}" class="h-5 w-5"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $activity->description }}</p>
                                <div class="mt-1 flex items-center gap-2 text-xs text-slate-400">
                                    <span>{{ optional($activity->user)->name ?? 'Automation' }}</span>
                                    <span>&middot;</span>
                                    <span>{{ $activity->occurred_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-ui.card>
        </div>

        <x-ui.card title="Leads vs Converted" subtitle="Breakdown of current funnel quality and conversion readiness.">
            <div class="rounded-[24px] bg-slate-50/70 p-4 dark:bg-slate-950/40">
                <canvas id="lead-conversion-chart" height="110"></canvas>
            </div>
        </x-ui.card>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const salesCtx = document.getElementById('sales-overview-chart');
            const leadCtx = document.getElementById('lead-conversion-chart');
            const Chart = await window.loadCharts();

            if (salesCtx) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: @json($charts['salesOverview']),
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        elements: {
                            line: { tension: 0.4, borderWidth: 3, borderColor: '#14b8a6' },
                            point: { radius: 0, hoverRadius: 5, backgroundColor: '#14b8a6' }
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: { border: { display: false } }
                        }
                    }
                });
            }

            if (leadCtx) {
                new Chart(leadCtx, {
                    type: 'bar',
                    data: {
                        ...@json($charts['leadConversion']),
                        datasets: @json($charts['leadConversion']['datasets']).map(dataset => ({
                            ...dataset,
                            backgroundColor: ['#cbd5e1', '#38bdf8', '#10b981', '#fb7185'],
                            borderRadius: 14,
                        }))
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { grid: { display: false } },
                            y: { border: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
@endpush
