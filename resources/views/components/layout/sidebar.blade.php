@php
    $items = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'layout-dashboard'],
        ['label' => 'Leads', 'route' => 'leads.index', 'icon' => 'users-round'],
        ['label' => 'Customers', 'route' => 'customers.index', 'icon' => 'building-2'],
        ['label' => 'Deals', 'route' => 'deals.index', 'icon' => 'briefcase-business'],
        ['label' => 'Tasks', 'route' => 'tasks.index', 'icon' => 'list-todo'],
    ];
@endphp

<aside
    class="fixed inset-y-0 left-0 z-40 flex w-80 max-w-[88vw] -translate-x-full flex-col border-r border-white/70 bg-white/88 px-4 py-5 shadow-[0_28px_80px_-36px_rgba(15,23,42,0.34)] backdrop-blur-2xl transition-all duration-300 dark:border-slate-800 dark:bg-slate-950/94 lg:translate-x-0"
    :class="{
        'translate-x-0': sidebarOpen,
        'lg:w-24': sidebarCollapsed,
        'lg:w-80': !sidebarCollapsed
    }"
>
    <div class="flex items-center justify-between px-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-400 via-cyan-400 to-sky-500 text-slate-950 shadow-lg shadow-teal-500/30">
                <span class="font-display text-lg font-extrabold">H</span>
            </div>
            <div x-show="!sidebarCollapsed" x-transition.opacity>
                <p class="crm-heading text-lg">Helix CRM</p>
                <p class="crm-subtext">Revenue workspace</p>
            </div>
        </a>
        <button class="rounded-2xl p-2 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 lg:hidden" @click="sidebarOpen = false">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>

    <div class="mt-8 rounded-[28px] bg-gradient-to-br from-slate-950 via-slate-900 to-teal-700 p-5 text-white shadow-xl shadow-slate-950/20" x-show="!sidebarCollapsed" x-transition>
        <p class="text-xs uppercase tracking-[0.24em] text-white/60">Quarter focus</p>
        <p class="mt-3 font-display text-xl font-bold leading-snug">Close 14 enterprise renewals before June 30.</p>
        <p class="mt-2 text-sm text-white/70">Monitor deal health, response times, and rep workload in one place.</p>
        <div class="mt-5 grid grid-cols-2 gap-3">
            <div class="rounded-2xl bg-white/10 px-3 py-3">
                <p class="text-xs text-white/55">Win rate</p>
                <p class="mt-1 font-display text-lg font-bold">34%</p>
            </div>
            <div class="rounded-2xl bg-white/10 px-3 py-3">
                <p class="text-xs text-white/55">Open ARR</p>
                <p class="mt-1 font-display text-lg font-bold">$184k</p>
            </div>
        </div>
    </div>

    <nav class="mt-8 space-y-2 rounded-[28px] border border-slate-200/75 bg-white/65 p-3 backdrop-blur dark:border-slate-800 dark:bg-slate-900/40">
        @foreach ($items as $item)
            <a
                href="{{ route($item['route']) }}"
                class="crm-sidebar-link {{ request()->routeIs($item['route']) ? 'crm-sidebar-link-active' : '' }}"
                :class="{ 'justify-center': sidebarCollapsed }"
            >
                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0"></i>
                <span x-show="!sidebarCollapsed" x-transition.opacity>{{ $item['label'] }}</span>
            </a>
        @endforeach
    </nav>

    <div class="mt-auto rounded-[28px] border border-slate-200/75 bg-white/70 p-4 backdrop-blur dark:border-slate-800 dark:bg-slate-900/72" x-show="!sidebarCollapsed" x-transition>
        <p class="crm-heading text-sm">{{ auth()->user()->name }}</p>
        <p class="crm-subtext">{{ str(auth()->user()->role)->headline() }} &middot; {{ auth()->user()->job_title }}</p>
    </div>
</aside>

<div
    class="fixed inset-0 z-30 bg-slate-950/30 backdrop-blur-sm lg:hidden"
    x-show="sidebarOpen"
    x-transition.opacity
    @click="sidebarOpen = false"
></div>
