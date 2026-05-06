<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDealRequest;
use App\Http\Requests\UpdateDealRequest;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\User;
use App\Support\CrmActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DealController extends Controller
{
    public function index(): View
    {
        return view('pages.deals.index', [
            'deals' => Deal::query()->with(['customer', 'owner'])->latest()->get(),
            'customers' => Customer::query()->orderBy('name')->get(),
            'leads' => Lead::query()->orderBy('name')->get(),
            'owners' => User::query()->orderBy('name')->get(),
            'stageOptions' => ['new', 'in_progress', 'negotiation', 'closed'],
        ]);
    }

    public function store(StoreDealRequest $request): RedirectResponse
    {
        $deal = Deal::query()->create($request->validated() + [
            'owner_id' => $request->validated('owner_id') ?: $request->user()->id,
        ]);

        CrmActivity::record('deal_created', "Created deal {$deal->title}.", $deal, $request->user()->id, 'briefcase');

        return back()->with('toast', ['type' => 'success', 'message' => 'Deal created successfully.']);
    }

    public function show(Deal $deal): View
    {
        $deal->load(['customer', 'lead', 'owner', 'tasks.assignee']);

        return view('pages.deals.show', compact('deal'));
    }

    public function update(UpdateDealRequest $request, Deal $deal): RedirectResponse
    {
        $deal->update($request->validated());

        CrmActivity::record('deal_updated', "Updated deal {$deal->title}.", $deal, $request->user()->id, 'arrows-right-left');

        return back()->with('toast', ['type' => 'success', 'message' => 'Deal updated successfully.']);
    }

    public function destroy(Request $request, Deal $deal): RedirectResponse
    {
        $title = $deal->title;
        $deal->delete();

        CrmActivity::record('deal_deleted', "Removed deal {$title}.", null, $request->user()->id, 'trash');

        return back()->with('toast', ['type' => 'success', 'message' => 'Deal deleted successfully.']);
    }

    public function updateStage(Request $request, Deal $deal): RedirectResponse
    {
        $validated = $request->validate([
            'stage' => ['required', 'in:new,in_progress,negotiation,closed'],
        ]);

        $deal->update(['stage' => $validated['stage']]);

        CrmActivity::record(
            'deal_stage_updated',
            'Moved '.$deal->title.' to '.str($validated['stage'])->headline().'.',
            $deal,
            $request->user()->id,
            'arrows-right-left'
        );

        return back()->with('toast', ['type' => 'success', 'message' => 'Deal stage updated.']);
    }
}
