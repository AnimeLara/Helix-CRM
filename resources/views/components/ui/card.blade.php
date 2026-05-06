@props(['title' => null, 'subtitle' => null, 'padded' => true])

<section {{ $attributes->class(['crm-card', 'p-6' => $padded]) }}>
    @if ($title || $subtitle)
        <div class="mb-5 flex items-start justify-between gap-4 border-b border-slate-200/70 pb-4 dark:border-slate-800/80">
            <div>
                @if ($title)
                    <h2 class="crm-heading text-lg">{{ $title }}</h2>
                @endif
                @if ($subtitle)
                    <p class="crm-subtext mt-1">{{ $subtitle }}</p>
                @endif
            </div>
            {{ $actions ?? '' }}
        </div>
    @endif

    {{ $slot }}
</section>
