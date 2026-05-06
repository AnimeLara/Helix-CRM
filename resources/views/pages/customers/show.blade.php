@extends('layouts.app')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <x-ui.card title="{{ $customer->name }}" subtitle="{{ $customer->company }}">
            <div class="grid gap-4 md:grid-cols-2">
                <div><p class="crm-subtext">Email</p><p class="mt-2 font-medium">{{ $customer->email }}</p></div>
                <div><p class="crm-subtext">Phone</p><p class="mt-2 font-medium">{{ $customer->phone }}</p></div>
                <div><p class="crm-subtext">Industry</p><p class="mt-2 font-medium">{{ $customer->industry }}</p></div>
                <div><p class="crm-subtext">Tag</p><div class="mt-2"><x-ui.badge tone="amber">{{ $customer->tag }}</x-ui.badge></div></div>
            </div>
            <div class="mt-6">
                <p class="crm-subtext">Interaction history</p>
                <div class="mt-4 space-y-4">
                    @foreach ($customer->interactions as $interaction)
                        <div class="crm-muted-card p-4">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-medium text-slate-900 dark:text-white">{{ $interaction->summary }}</p>
                                <x-ui.badge tone="sky">{{ $interaction->type }}</x-ui.badge>
                            </div>
                            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">{{ optional($interaction->user)->name }} • {{ $interaction->happened_at->format('M d, Y h:i A') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </x-ui.card>

        <x-ui.card title="Open work" subtitle="Related deals and account tasks.">
            <div class="space-y-4">
                @foreach ($customer->deals as $deal)
                    <div class="crm-muted-card p-4">
                        <p class="font-medium text-slate-900 dark:text-white">{{ $deal->title }}</p>
                        <p class="crm-subtext mt-1">${{ number_format($deal->amount, 0) }} • {{ str($deal->stage)->headline() }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.card>
    </div>
@endsection
