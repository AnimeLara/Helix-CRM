@props(['name', 'title', 'description' => null, 'maxWidth' => 'max-w-3xl'])

<div
    x-cloak
    x-show="{{ $name }}"
    x-transition.opacity
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-8"
>
    <div class="fixed inset-0 bg-slate-950/50 backdrop-blur-sm"></div>
    <div class="relative mx-auto {{ $maxWidth }}">
        <div class="crm-card p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="crm-heading text-xl">{{ $title }}</h3>
                    @if ($description)
                        <p class="crm-subtext mt-1">{{ $description }}</p>
                    @endif
                </div>
                <button class="rounded-2xl p-2 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800" @click="{{ $name }} = false">
                    <i data-lucide="x" class="h-5 w-5"></i>
                </button>
            </div>
            <div class="mt-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
