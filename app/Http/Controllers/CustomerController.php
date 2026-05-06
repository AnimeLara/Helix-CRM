<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use App\Repositories\CustomerRepository;
use App\Support\CrmActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function __construct(protected CustomerRepository $customers)
    {
    }

    public function index(Request $request): View
    {
        return view('pages.customers.index', [
            'customers' => $this->customers->query($request->string('search')->toString())->latest()->paginate(9)->withQueryString(),
            'owners' => User::query()->orderBy('name')->get(),
            'viewMode' => $request->get('view', 'table'),
        ]);
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $customer = Customer::query()->create($request->validated() + [
            'owner_id' => $request->validated('owner_id') ?: $request->user()->id,
        ]);

        CrmActivity::record('customer_created', "Added customer {$customer->name}.", $customer, $request->user()->id, 'user-plus');

        return back()->with('toast', ['type' => 'success', 'message' => 'Customer created successfully.']);
    }

    public function show(Customer $customer): View
    {
        $customer->load(['owner', 'interactions.user', 'deals.owner', 'tasks.assignee']);

        return view('pages.customers.show', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());

        CrmActivity::record('customer_updated', "Updated customer {$customer->name}.", $customer, $request->user()->id, 'pencil-square');

        return back()->with('toast', ['type' => 'success', 'message' => 'Customer updated successfully.']);
    }

    public function destroy(Request $request, Customer $customer): RedirectResponse
    {
        $name = $customer->name;
        $customer->delete();

        CrmActivity::record('customer_deleted', "Removed customer {$name}.", null, $request->user()->id, 'trash');

        return back()->with('toast', ['type' => 'success', 'message' => 'Customer deleted successfully.']);
    }
}
