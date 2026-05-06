<?php

namespace App\Livewire;

use App\Repositories\LeadRepository;
use Livewire\Component;
use Livewire\WithPagination;

class LeadTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $source = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingSource(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->sortField = $field;
        $this->sortDirection = 'asc';
    }

    public function render(LeadRepository $leads)
    {
        return view('livewire.lead-table', [
            'leads' => $leads->query([
                'search' => $this->search,
                'status' => $this->status,
                'source' => $this->source,
            ])->orderBy($this->sortField, $this->sortDirection)->paginate(10),
        ]);
    }
}
