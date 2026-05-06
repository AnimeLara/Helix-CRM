@extends('layouts.app')

@section('content')
    <div x-data="customerModal()" class="space-y-6">
        <section class="crm-page-header">
            <div class="crm-page-header-content">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-teal-600 dark:text-teal-300">Customers</p>
                    <h2 class="crm-heading mt-2 text-3xl">Manage accounts with flexible table and grid views.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500 dark:text-slate-400">Browse accounts in whichever format suits the workflow while keeping quick edit access close at hand.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customers.index', ['view' => 'table', 'search' => request('search')]) }}" class="{{ $viewMode === 'table' ? 'crm-btn-primary' : 'crm-btn-secondary' }}">Table</a>
                    <a href="{{ route('customers.index', ['view' => 'grid', 'search' => request('search')]) }}" class="{{ $viewMode === 'grid' ? 'crm-btn-primary' : 'crm-btn-secondary' }}">Grid</a>
                    <button type="button" class="crm-btn-primary" @click="create()">Add customer</button>
                </div>
            </div>
            <form class="mt-5">
                <input type="text" name="search" value="{{ request('search') }}" class="crm-input max-w-md" placeholder="Search customers">
            </form>
        </section>

        @if ($viewMode === 'grid')
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($customers as $customer)
                    <x-ui.card>
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="crm-heading text-lg">{{ $customer->name }}</h3>
                                <p class="crm-subtext mt-1">{{ $customer->company }}</p>
                            </div>
                            <x-ui.badge :tone="match($customer->tag) { 'vip' => 'amber', 'partner' => 'violet', default => 'sky' }">{{ $customer->tag }}</x-ui.badge>
                        </div>
                        <div class="mt-5 space-y-2 text-sm text-slate-600 dark:text-slate-300">
                            <p>{{ $customer->email }}</p>
                            <p>{{ $customer->phone }}</p>
                            <p>{{ $customer->industry }}</p>
                        </div>
                        <div class="mt-5 flex gap-3">
                            <a href="{{ route('customers.show', $customer) }}" class="crm-btn-secondary">Open</a>
                            <button type="button" class="crm-btn-secondary" @click='edit(@json($customer))'>Edit</button>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
        @else
            <x-ui.card>
                <x-ui.table class="bg-white/70 dark:bg-slate-900/60">
                    <thead class="bg-slate-50/80 dark:bg-slate-800/80">
                        <tr class="text-left text-sm text-slate-500 dark:text-slate-300">
                            <th class="px-5 py-4 font-medium">Customer</th>
                            <th class="px-5 py-4 font-medium">Tag</th>
                            <th class="px-5 py-4 font-medium">Owner</th>
                            <th class="px-5 py-4 font-medium">Status</th>
                            <th class="px-5 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/80 text-sm dark:divide-slate-800">
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $customer->name }}</p>
                                    <p class="crm-subtext">{{ $customer->company }}</p>
                                </td>
                                <td class="px-5 py-4"><x-ui.badge :tone="match($customer->tag) { 'vip' => 'amber', 'partner' => 'violet', default => 'sky' }">{{ $customer->tag }}</x-ui.badge></td>
                                <td class="px-5 py-4">{{ optional($customer->owner)->name }}</td>
                                <td class="px-5 py-4">{{ str($customer->status)->headline() }}</td>
                                <td class="px-5 py-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('customers.show', $customer) }}" class="crm-btn-secondary px-3 py-2">Open</a>
                                        <button type="button" class="crm-btn-secondary px-3 py-2" @click='edit(@json($customer))'>Edit</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-ui.table>
            </x-ui.card>
        @endif

        <div>{{ $customers->links() }}</div>

        <x-ui.modal name="open" title="Customer record" description="Capture account details, tags, and ownership.">
            <form method="POST" :action="action" class="grid gap-4 md:grid-cols-2">
                @csrf
                <input type="hidden" name="_method" :value="method">
                <x-ui.input label="Name" name="name" x-model="form.name" required />
                <x-ui.input label="Company" name="company" x-model="form.company" />
                <x-ui.input label="Email" name="email" type="email" x-model="form.email" />
                <x-ui.input label="Phone" name="phone" x-model="form.phone" />
                <x-ui.select label="Tag" name="tag" x-model="form.tag">
                    <option value="vip">VIP</option>
                    <option value="regular">Regular</option>
                    <option value="partner">Partner</option>
                </x-ui.select>
                <x-ui.select label="Status" name="status" x-model="form.status">
                    <option value="active">Active</option>
                    <option value="onboarding">Onboarding</option>
                    <option value="churn-risk">Churn Risk</option>
                </x-ui.select>
                <x-ui.input label="Industry" name="industry" x-model="form.industry" />
                <x-ui.select label="Owner" name="owner_id" x-model="form.owner_id">
                    @foreach ($owners as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </x-ui.select>
                <div class="md:col-span-2">
                    <x-ui.input label="Address" name="address" x-model="form.address" />
                </div>
                <div class="md:col-span-2">
                    <x-ui.textarea label="Notes" name="notes" x-model="form.notes"></x-ui.textarea>
                </div>
                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button" class="crm-btn-secondary" @click="open = false">Cancel</button>
                    <button type="submit" class="crm-btn-primary" x-text="mode === 'create' ? 'Create customer' : 'Save changes'"></button>
                </div>
            </form>
        </x-ui.modal>
    </div>
@endsection

@push('scripts')
    <script>
        function customerModal() {
            return {
                open: false,
                mode: 'create',
                action: @js(route('customers.store')),
                method: 'POST',
                form: {
                    id: null,
                    name: '',
                    company: '',
                    email: '',
                    phone: '',
                    tag: 'regular',
                    status: 'active',
                    industry: '',
                    owner_id: @js($owners->first()?->id),
                    address: '',
                    notes: ''
                },
                create() {
                    this.mode = 'create';
                    this.action = @js(route('customers.store'));
                    this.method = 'POST';
                    this.form = { id: null, name: '', company: '', email: '', phone: '', tag: 'regular', status: 'active', industry: '', owner_id: @js($owners->first()?->id), address: '', notes: '' };
                    this.open = true;
                },
                edit(customer) {
                    this.mode = 'edit';
                    this.action = `/customers/${customer.id}`;
                    this.method = 'PATCH';
                    this.form = { ...this.form, ...customer };
                    this.open = true;
                }
            };
        }
    </script>
@endpush
