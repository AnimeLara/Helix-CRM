@extends('layouts.app')

@section('content')
    <div x-data="leadModal()" @open-lead-modal.window="edit($event.detail)" class="space-y-6">
        <section class="crm-page-header">
            <div class="crm-page-header-content">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-600 dark:text-teal-300">Leads management</p>
                    <h2 class="crm-heading mt-2 text-3xl">Track every lead source and qualification step.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">Search, qualify, and update leads in a cleaner workflow with export support and inline editing.</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('leads.export') }}" class="crm-btn-secondary">Export CSV</a>
                    <button type="button" class="crm-btn-primary" @click="create()">Add lead</button>
                </div>
            </div>
        </section>

        <x-ui.card title="Lead Pipeline" subtitle="Search, filter, sort, and update leads without leaving the page.">
            <livewire:lead-table />
        </x-ui.card>

        <x-ui.modal name="open" title="Lead details" description="Create or update lead information in a compact workflow.">
            <form method="POST" :action="action" class="grid gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="_method" :value="method">
                <x-ui.input label="Full name" name="name" x-model="form.name" required />
                <x-ui.input label="Email" name="email" type="email" x-model="form.email" />
                <x-ui.input label="Phone" name="phone" x-model="form.phone" />
                <x-ui.input label="Company" name="company" x-model="form.company" />
                <x-ui.select label="Status" name="status" x-model="form.status">
                    @foreach ($statusOptions as $status)
                        <option value="{{ $status }}">{{ str($status)->headline() }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select label="Source" name="source" x-model="form.source">
                    @foreach ($sourceOptions as $source)
                        <option value="{{ $source }}">{{ str($source)->headline() }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select label="Owner" name="owner_id" x-model="form.owner_id">
                    @foreach ($owners as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.input label="Expected value" name="expected_value" type="number" step="0.01" min="0" x-model="form.expected_value" />
                <div class="md:col-span-2">
                    <x-ui.textarea label="Notes" name="notes" x-model="form.notes"></x-ui.textarea>
                </div>
                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button" class="crm-btn-secondary" @click="open = false">Cancel</button>
                    <button type="submit" class="crm-btn-primary" x-text="mode === 'create' ? 'Create lead' : 'Save changes'"></button>
                </div>
            </form>
        </x-ui.modal>
    </div>
@endsection

@push('scripts')
    <script>
        function leadModal() {
            return {
                open: false,
                mode: 'create',
                action: @js(route('leads.store')),
                method: 'POST',
                form: {
                    id: null,
                    name: '',
                    email: '',
                    phone: '',
                    company: '',
                    status: 'new',
                    source: 'website',
                    owner_id: @js($owners->first()?->id),
                    expected_value: '',
                    notes: '',
                },
                create() {
                    this.mode = 'create';
                    this.action = @js(route('leads.store'));
                    this.method = 'POST';
                    this.form = { id: null, name: '', email: '', phone: '', company: '', status: 'new', source: 'website', owner_id: @js($owners->first()?->id), expected_value: '', notes: '' };
                    this.open = true;
                },
                edit(lead) {
                    this.mode = 'edit';
                    this.action = `/leads/${lead.id}`;
                    this.method = 'PATCH';
                    this.form = { ...lead };
                    this.open = true;
                }
            };
        }
    </script>
@endpush
