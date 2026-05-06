@extends('layouts.app')

@section('content')
    <div x-data="taskModal()" class="space-y-6">
        <section class="crm-page-header">
            <div class="crm-page-header-content">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-600 dark:text-teal-300">Tasks and activities</p>
                    <h2 class="crm-heading mt-2 text-3xl">Stay on top of follow-ups, due dates, and ownership.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">Keep execution tight with cleaner task cards, due-date context, and stronger action visibility.</p>
                </div>
                <button type="button" class="crm-btn-primary" @click="create()">Create task</button>
            </div>
        </section>

        <x-ui.card title="Task Queue" subtitle="Mark work complete, rebalance assignments, and keep momentum visible.">
            <div class="space-y-4">
                @foreach ($tasks as $task)
                    <div class="crm-muted-card p-5">
                        <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                            <div>
                                <div class="flex items-center gap-3">
                                    <h3 class="font-semibold text-slate-900 dark:text-white">{{ $task->title }}</h3>
                                    <x-ui.badge :tone="match($task->priority) { 'high' => 'rose', 'medium' => 'amber', default => 'sky' }">{{ $task->priority }}</x-ui.badge>
                                    <x-ui.badge :tone="match($task->status) { 'completed' => 'emerald', 'in_progress' => 'sky', default => 'slate' }">{{ str($task->status)->headline() }}</x-ui.badge>
                                </div>
                                <p class="crm-subtext mt-2">{{ $task->description }}</p>
                                <div class="mt-3 flex flex-wrap gap-4 text-sm text-slate-500 dark:text-slate-400">
                                    <span>Assigned to {{ optional($task->assignee)->name }}</span>
                                    <span>Due {{ optional($task->due_date)->format('M d, Y') ?: 'TBD' }}</span>
                                    <span>{{ optional($task->customer)->company ?: 'No account linked' }}</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @if ($task->status !== 'completed')
                                    <form method="POST" action="{{ route('tasks.complete', $task) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="crm-btn-primary">Mark complete</button>
                                    </form>
                                @endif
                                <a href="{{ route('tasks.show', $task) }}" class="crm-btn-secondary">Open</a>
                                <button type="button" class="crm-btn-secondary" @click='edit(@json($task))'>Edit</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <x-ui.modal name="open" title="Task details" description="Capture due dates, status, and ownership.">
            <form method="POST" :action="action" class="grid gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="_method" :value="method">
                <div class="md:col-span-2">
                    <x-ui.input label="Task title" name="title" x-model="form.title" required />
                </div>
                <x-ui.select label="Assignee" name="assigned_to" x-model="form.assigned_to">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.input label="Due date" name="due_date" type="date" x-model="form.due_date" />
                <x-ui.select label="Status" name="status" x-model="form.status">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In Progress</option>
                    <option value="completed">Completed</option>
                </x-ui.select>
                <x-ui.select label="Priority" name="priority" x-model="form.priority">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </x-ui.select>
                <x-ui.select label="Customer" name="customer_id" x-model="form.customer_id">
                    <option value="">Select customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->company }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select label="Deal" name="deal_id" x-model="form.deal_id">
                    <option value="">Select deal</option>
                    @foreach ($deals as $deal)
                        <option value="{{ $deal->id }}">{{ $deal->title }}</option>
                    @endforeach
                </x-ui.select>
                <div class="md:col-span-2">
                    <x-ui.textarea label="Description" name="description" x-model="form.description"></x-ui.textarea>
                </div>
                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button" class="crm-btn-secondary" @click="open = false">Cancel</button>
                    <button type="submit" class="crm-btn-primary" x-text="mode === 'create' ? 'Create task' : 'Save changes'"></button>
                </div>
            </form>
        </x-ui.modal>
    </div>
@endsection

@push('scripts')
    <script>
        function taskModal() {
            return {
                open: false,
                mode: 'create',
                action: @js(route('tasks.store')),
                method: 'POST',
                form: {
                    id: null,
                    title: '',
                    assigned_to: @js($users->first()?->id),
                    due_date: '',
                    status: 'pending',
                    priority: 'medium',
                    customer_id: '',
                    deal_id: '',
                    description: ''
                },
                create() {
                    this.mode = 'create';
                    this.action = @js(route('tasks.store'));
                    this.method = 'POST';
                    this.form = { id: null, title: '', assigned_to: @js($users->first()?->id), due_date: '', status: 'pending', priority: 'medium', customer_id: '', deal_id: '', description: '' };
                    this.open = true;
                },
                edit(task) {
                    this.mode = 'edit';
                    this.action = `/tasks/${task.id}`;
                    this.method = 'PATCH';
                    this.form = { ...this.form, ...task };
                    this.open = true;
                }
            };
        }
    </script>
@endpush
