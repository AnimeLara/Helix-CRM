<?php

namespace App\Livewire;

use App\Models\Deal;
use Livewire\Component;

class DealPipeline extends Component
{
    public array $stages = ['new', 'in_progress', 'negotiation', 'closed'];

    public function move(int $dealId, string $stage): void
    {
        Deal::query()->findOrFail($dealId)->update(['stage' => $stage]);
    }

    public function render()
    {
        return view('livewire.deal-pipeline', [
            'deals' => Deal::query()->with(['customer', 'owner'])->orderByDesc('amount')->get()->groupBy('stage'),
        ]);
    }
}
