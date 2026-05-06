@extends('layouts.app')

@section('content')
    <div x-data="dealModal()" class="space-y-6">
        <section class="crm-page-header">
            <div class="crm-page-header-content">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-600 dark:text-teal-300">Deals pipeline</p>
                    <h2 class="crm-heading mt-2 text-3xl">Visualize every stage from discovery to close.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">Use the kanban board for movement and the list view for fast operational edits across the forecast.</p>
                </div>
                <button type="button" class="crm-btn-primary" @click="create()">Create deal</button>
            </div>
        </section>

        <x-ui.card title="Pipeline Board" subtitle="Drag deals across stages to keep your forecast current.">
            <livewire:deal-pipeline />
        </x-ui.card>

        <x-ui.card title="Deal List" subtitle="Use quick edits for amount, owner, and close timeline.">
            <x-ui.table class="bg-white/70 dark:bg-slate-900/60">
                <thead class="bg-slate-50/80 dark:bg-slate-800/80">
                    <tr class="text-left text-sm text-slate-500 dark:text-slate-300">
                        <th class="px-5 py-4 font-medium">Deal</th>
                        <th class="px-5 py-4 font-medium">Client</th>
                        <th class="px-5 py-4 font-medium">Stage</th>
                        <th class="px-5 py-4 font-medium">Amount</th>
                        <th class="px-5 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/80 text-sm dark:divide-slate-800">
                    @foreach ($deals as $deal)
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $deal->title }}</p>
                                <p class="crm-subtext">{{ optional($deal->owner)->name }}</p>
                            </td>
                            <td class="px-5 py-4">{{ optional($deal->customer)->company ?: 'Prospect account' }}</td>
                            <td class="px-5 py-4">{{ str($deal->stage)->headline() }}</td>
                            <td class="px-5 py-4">${{ number_format($deal->amount, 0) }}</td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('deals.show', $deal) }}" class="crm-btn-secondary px-3 py-2">Open</a>
                                    <button type="button" class="crm-btn-secondary px-3 py-2" @click='edit(@json($deal))'>Edit</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-ui.table>
        </x-ui.card>

        <x-ui.modal name="open" title="Deal workspace" description="Create a new deal or update the current opportunity.">
            <form method="POST" :action="action" class="grid gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="_method" :value="method">
                <x-ui.input label="Deal title" name="title" x-model="form.title" required />
                <x-ui.input label="Amount" name="amount" type="number" step="0.01" min="0" x-model="form.amount" required />
                <x-ui.select label="Customer" name="customer_id" x-model="form.customer_id">
                    <option value="">Select customer</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->company }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select label="Lead" name="lead_id" x-model="form.lead_id">
                    <option value="">Select lead</option>
                    @foreach ($leads as $lead)
                        <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select label="Stage" name="stage" x-model="form.stage">
                    @foreach ($stageOptions as $stage)
                        <option value="{{ $stage }}">{{ str($stage)->headline() }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.select label="Owner" name="owner_id" x-model="form.owner_id">
                    @foreach ($owners as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </x-ui.select>
                <x-ui.input label="Probability %" name="probability" type="number" min="0" max="100" x-model="form.probability" />
                <x-ui.input label="Expected close date" name="expected_close_date" type="date" x-model="form.expected_close_date" />
                <div class="md:col-span-2">
                    <x-ui.textarea label="Description" name="description" x-model="form.description"></x-ui.textarea>
                </div>
                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button" class="crm-btn-secondary" @click="open = false">Cancel</button>
                    <button type="submit" class="crm-btn-primary" x-text="mode === 'create' ? 'Create deal' : 'Save changes'"></button>
                </div>
            </form>
        </x-ui.modal>
    </div>
@endsection

@push('scripts')
    <script>
        function dealModal() {
            return {
                open: false,
                mode: 'create',
                action: @js(route('deals.store')),
                method: 'POST',
                form: {
                    id: null,
                    title: '',
                    amount: '',
                    customer_id: '',
                    lead_id: '',
                    owner_id: @js($owners->first()?->id),
                    stage: 'new',
                    probability: 20,
                    expected_close_date: '',
                    description: ''
                },
                create() {
                    this.mode = 'create';
                    this.action = @js(route('deals.store'));
                    this.method = 'POST';
                    this.form = { id: null, title: '', amount: '', customer_id: '', lead_id: '', owner_id: @js($owners->first()?->id), stage: 'new', probability: 20, expected_close_date: '', description: '' };
                    this.open = true;
                },
                edit(deal) {
                    this.mode = 'edit';
                    this.action = `/deals/${deal.id}`;
                    this.method = 'PATCH';
                    this.form = { ...this.form, ...deal };
                    this.open = true;
                }
            };
        }
    </script>
@endpush
