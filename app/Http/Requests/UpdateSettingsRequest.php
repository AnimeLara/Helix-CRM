<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'theme' => ['required', 'in:light,dark'],
            'notification_preferences.email_updates' => ['nullable', 'boolean'],
            'notification_preferences.deal_alerts' => ['nullable', 'boolean'],
            'notification_preferences.weekly_summary' => ['nullable', 'boolean'],
        ];
    }
}
