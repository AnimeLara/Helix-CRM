<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function list(): Collection
    {
        return Task::query()
            ->with(['assignee', 'customer', 'deal'])
            ->orderByRaw("FIELD(status, 'pending', 'in_progress', 'completed')")
            ->orderBy('due_date')
            ->get();
    }
}
