@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <x-ui.card title="{{ $lead->name }}" subtitle="{{ $lead->company ?: 'Independent buyer' }}">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div><p class="crm-subtext">Email</p><p class="mt-2 font-medium">{{ $lead->email ?: 'N/A' }}</p></div>
                <div><p class="crm-subtext">Phone</p><p class="mt-2 font-medium">{{ $lead->phone ?: 'N/A' }}</p></div>
                <div><p class="crm-subtext">Status</p><div class="mt-2"><x-ui.badge tone="sky">{{ str($lead->status)->headline() }}</x-ui.badge></div></div>
                <div><p class="crm-subtext">Source</p><p class="mt-2 font-medium">{{ str($lead->source)->headline() }}</p></div>
            </div>
            <div class="mt-6">
                <p class="crm-subtext">Notes</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $lead->notes ?: 'No notes captured yet.' }}</p>
            </div>
        </x-ui.card>
    </div>
@endsection
