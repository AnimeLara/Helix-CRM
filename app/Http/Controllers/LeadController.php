<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\User;
use App\Repositories\LeadRepository;
use App\Support\CrmActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function __construct(protected LeadRepository $leads)
    {
    }

    public function index(): View
    {
        return view('pages.leads.index', [
            'owners' => User::query()->orderBy('name')->get(),
            'statusOptions' => ['new', 'contacted', 'qualified', 'lost'],
            'sourceOptions' => ['website', 'referral', 'campaign', 'linkedin', 'cold-call'],
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        $lead = Lead::query()->create($request->validated() + [
            'owner_id' => $request->validated('owner_id') ?: $request->user()->id,
        ]);

        CrmActivity::record('lead_created', "Added lead {$lead->name}.", $lead, $request->user()->id, 'sparkles');

        return back()->with('toast', ['type' => 'success', 'message' => 'Lead created successfully.']);
    }

    public function show(Lead $lead): View
    {
        $lead->load(['owner', 'deals.customer']);

        return view('pages.leads.show', compact('lead'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        $lead->update($request->validated());

        CrmActivity::record('lead_updated', "Updated lead {$lead->name}.", $lead, $request->user()->id, 'pencil-square');

        return back()->with('toast', ['type' => 'success', 'message' => 'Lead updated successfully.']);
    }

    public function destroy(Request $request, Lead $lead): RedirectResponse
    {
        $name = $lead->name;
        $lead->delete();

        CrmActivity::record('lead_deleted', "Removed lead {$name}.", null, $request->user()->id, 'trash');

        return back()->with('toast', ['type' => 'success', 'message' => 'Lead deleted successfully.']);
    }

    public function export(Request $request)
    {
        $leads = $this->leads->query($request->only(['search', 'status', 'source']))->get();

        $csv = implode(',', ['Name', 'Email', 'Phone', 'Status', 'Source']).PHP_EOL;
        $csv .= $leads->map(fn (Lead $lead) => implode(',', [
            $this->escapeCsv($lead->name),
            $this->escapeCsv($lead->email),
            $this->escapeCsv($lead->phone),
            $this->escapeCsv($lead->status),
            $this->escapeCsv($lead->source),
        ]))->implode(PHP_EOL);

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="leads-export.csv"',
        ]);
    }

    protected function escapeCsv(?string $value): string
    {
        $value = str_replace('"', '""', (string) $value);

        return "\"{$value}\"";
    }
}
