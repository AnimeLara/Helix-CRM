<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Support\CrmActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(Request $request): View
    {
        return view('pages.settings.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        $preferences = $request->validated('notification_preferences') ?? [];

        $request->user()->update([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'phone' => $request->validated('phone'),
            'job_title' => $request->validated('job_title'),
            'theme' => $request->validated('theme'),
            'notification_preferences' => [
                'email_updates' => (bool) ($preferences['email_updates'] ?? false),
                'deal_alerts' => (bool) ($preferences['deal_alerts'] ?? false),
                'weekly_summary' => (bool) ($preferences['weekly_summary'] ?? false),
            ],
        ]);

        CrmActivity::record('settings_updated', 'Updated workspace settings preferences.', $request->user(), $request->user()->id, 'cog-6-tooth');

        return back()->with('toast', ['type' => 'success', 'message' => 'Settings updated successfully.']);
    }
}
