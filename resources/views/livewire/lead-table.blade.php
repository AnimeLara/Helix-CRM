<div class="space-y-6">
    <div class="grid gap-4 lg:grid-cols-4">
        <label class="block lg:col-span-2">
            <span class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Search leads</span>
            <input type="text" wire:model.live.debounce.300ms="search" class="crm-input" placeholder="Search by name, email, company, or phone">
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Status</span>
            <select wire:model.live="status" class="crm-input">
                <option value="">All statuses</option>
                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="qualified">Qualified</option>
                <option value="lost">Lost</option>
            </select>
        </label>
        <label class="block">
            <span class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">Source</span>
            <select wire:model.live="source" class="crm-input">
                <option value="">All sources</option>
                <option value="website">Website</option>
                <option value="referral">Referral</option>
                <option value="campaign">Campaign</option>
                <option value="linkedin">LinkedIn</option>
                <option value="cold-call">Cold Call</option>
            </select>
        </label>
    </div>

    <x-ui.table class="bg-white/70 dark:bg-slate-900/60">
        <thead class="bg-slate-50/80 dark:bg-slate-800/80">
            <tr class="text-left text-sm text-slate-500 dark:text-slate-300">
                @foreach (['name' => 'Lead', 'email' => 'Email', 'phone' => 'Phone', 'status' => 'Status', 'source' => 'Source'] as $field => $label)
                    <th class="px-5 py-4 font-medium">
                        <button class="inline-flex items-center gap-2" wire:click="sortBy('{{ $field }}')">
                            {{ $label }}
                            <i data-lucide="arrow-up-down" class="h-4 w-4"></i>
                        </button>
                    </th>
                @endforeach
                <th class="px-5 py-4"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200/80 text-sm dark:divide-slate-800">
            @forelse ($leads as $lead)
                <tr class="text-slate-600 dark:text-slate-300">
                    <td class="px-5 py-4">
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $lead->name }}</p>
                            <p class="crm-subtext">{{ $lead->company ?: 'Independent buyer' }}</p>
                        </div>
                    </td>
                    <td class="px-5 py-4">{{ $lead->email ?: 'N/A' }}</td>
                    <td class="px-5 py-4">{{ $lead->phone ?: 'N/A' }}</td>
                    <td class="px-5 py-4">
                        <x-ui.badge :tone="match($lead->status) {
                            'qualified' => 'emerald',
                            'contacted' => 'sky',
                            'lost' => 'rose',
                            default => 'amber'
                        }">{{ str($lead->status)->headline() }}</x-ui.badge>
                    </td>
                    <td class="px-5 py-4">{{ str($lead->source)->headline() }}</td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('leads.show', $lead) }}" class="crm-btn-secondary px-3 py-2">View</a>
                            <button
                                type="button"
                                class="crm-btn-secondary px-3 py-2"
                                x-on:click="$dispatch('open-lead-modal', @js([
                                    'id' => $lead->id,
                                    'name' => $lead->name,
                                    'email' => $lead->email,
                                    'phone' => $lead->phone,
                                    'company' => $lead->company,
                                    'status' => $lead->status,
                                    'source' => $lead->source,
                                    'owner_id' => $lead->owner_id,
                                    'expected_value' => $lead->expected_value,
                                    'notes' => $lead->notes,
                                ]))"
                            >
                                Edit
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-sm text-slate-500 dark:text-slate-400">No leads match your filters yet.</td>
                </tr>
            @endforelse
        </tbody>
    </x-ui.table>

    <div>
        {{ $leads->links() }}
    </div>
</div>
