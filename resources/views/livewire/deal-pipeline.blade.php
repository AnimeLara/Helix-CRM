<div
    class="grid gap-5 xl:grid-cols-4"
    x-data
    x-init="(async () => {
        const Sortable = await window.loadSortable();
        $nextTick(() => {
            Array.from($el.querySelectorAll('[data-stage]')).forEach((column) => {
                Sortable.create(column, {
                    group: 'pipeline',
                    animation: 180,
                    onAdd(event) {
                        $wire.move(event.item.dataset.dealId, column.dataset.stage);
                    },
                });
            });
        });
    })()"
>
    @foreach ($stages as $stage)
        <div class="crm-card p-4">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h3 class="crm-heading text-base">{{ str($stage)->headline() }}</h3>
                    <p class="crm-subtext">{{ ($deals[$stage] ?? collect())->count() }} deals</p>
                </div>
                <x-ui.badge :tone="match($stage) {
                    'closed' => 'emerald',
                    'negotiation' => 'amber',
                    'in_progress' => 'sky',
                    default => 'slate'
                }">{{ strtoupper(substr($stage, 0, 1)) }}</x-ui.badge>
            </div>

            <div class="space-y-3 min-h-32" data-stage="{{ $stage }}">
                @forelse (($deals[$stage] ?? collect()) as $deal)
                    <article class="crm-muted-card cursor-grab p-4" data-deal-id="{{ $deal->id }}" wire:key="deal-{{ $deal->id }}">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $deal->title }}</p>
                                <p class="crm-subtext mt-1">{{ optional($deal->customer)->company ?: 'Prospect account' }}</p>
                            </div>
                            <x-ui.badge tone="violet">{{ $deal->probability }}%</x-ui.badge>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="font-semibold text-slate-900 dark:text-white">${{ number_format($deal->amount, 0) }}</span>
                            <span class="crm-subtext">{{ optional($deal->owner)->name }}</span>
                        </div>
                    </article>
                @empty
                    <div class="rounded-2xl border border-dashed border-slate-300 px-4 py-8 text-center text-sm text-slate-400 dark:border-slate-700">Drop a deal here</div>
                @endforelse
            </div>
        </div>
    @endforeach
</div>
