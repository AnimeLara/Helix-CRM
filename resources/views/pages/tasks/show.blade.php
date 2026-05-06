@extends('layouts.app')

@section('content')
    <x-ui.card title="{{ $task->title }}" subtitle="{{ optional($task->customer)->company ?: 'Internal task' }}">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div><p class="crm-subtext">Assignee</p><p class="mt-2 font-medium">{{ optional($task->assignee)->name }}</p></div>
            <div><p class="crm-subtext">Due date</p><p class="mt-2 font-medium">{{ optional($task->due_date)->format('M d, Y') ?: 'TBD' }}</p></div>
            <div><p class="crm-subtext">Status</p><p class="mt-2 font-medium">{{ str($task->status)->headline() }}</p></div>
            <div><p class="crm-subtext">Priority</p><p class="mt-2 font-medium">{{ str($task->priority)->headline() }}</p></div>
        </div>
        <div class="mt-6">
            <p class="crm-subtext">Description</p>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $task->description ?: 'No additional description.' }}</p>
        </div>
    </x-ui.card>
@endsection
