@extends('layouts.app')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <x-ui.card title="{{ $deal->title }}" subtitle="{{ optional($deal->customer)->company ?: 'Prospect account' }}">
            <div class="grid gap-4 md:grid-cols-2">
                <div><p class="crm-subtext">Amount</p><p class="mt-2 font-medium">${{ number_format($deal->amount, 0) }}</p></div>
                <div><p class="crm-subtext">Stage</p><p class="mt-2 font-medium">{{ str($deal->stage)->headline() }}</p></div>
                <div><p class="crm-subtext">Probability</p><p class="mt-2 font-medium">{{ $deal->probability }}%</p></div>
                <div><p class="crm-subtext">Close date</p><p class="mt-2 font-medium">{{ optional($deal->expected_close_date)->format('M d, Y') ?: 'TBD' }}</p></div>
            </div>
            <div class="mt-6">
                <p class="crm-subtext">Description</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $deal->description ?: 'No deal notes yet.' }}</p>
            </div>
        </x-ui.card>
        <x-ui.card title="Linked tasks" subtitle="Execution items attached to this opportunity.">
            <div class="space-y-4">
                @forelse ($deal->tasks as $task)
                    <div class="crm-muted-card p-4">
                        <p class="font-medium text-slate-900 dark:text-white">{{ $task->title }}</p>
                        <p class="crm-subtext mt-1">{{ optional($task->assignee)->name }} • {{ $task->status }}</p>
                    </div>
                @empty
                    <p class="crm-subtext">No related tasks yet.</p>
                @endforelse
            </div>
        </x-ui.card>
    </div>
@endsection
