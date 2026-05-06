<div
    x-data="{ show: @js(session()->has('toast')), toast: @js(session('toast')) }"
    x-show="show"
    x-transition
    x-init="if (show) setTimeout(() => show = false, 3200)"
    class="fixed bottom-6 right-6 z-50"
>
    <div class="min-w-80 rounded-3xl border border-slate-200 bg-white px-5 py-4 shadow-2xl shadow-slate-950/10 dark:border-slate-700 dark:bg-slate-900">
        <p class="text-sm font-semibold text-slate-900 dark:text-white" x-text="toast?.type === 'success' ? 'Success' : 'Notice'"></p>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400" x-text="toast?.message"></p>
    </div>
</div>
