<div {{ $attributes->class(['crm-table-shell']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200/80 dark:divide-slate-700/80">
            {{ $slot }}
        </table>
    </div>
</div>
