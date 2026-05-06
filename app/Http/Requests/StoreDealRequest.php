<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'customer_id' => ['nullable', 'exists:customers,id'],
            'lead_id' => ['nullable', 'exists:leads,id'],
            'owner_id' => ['nullable', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'stage' => ['required', 'in:new,in_progress,negotiation,closed'],
            'probability' => ['required', 'integer', 'min:0', 'max:100'],
            'expected_close_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
        ];
    }
}
