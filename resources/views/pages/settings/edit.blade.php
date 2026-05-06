@extends('layouts.app')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[0.95fr_1.05fr]">
        <x-ui.card title="Workspace profile" subtitle="Update the admin-facing identity for your CRM workspace.">
            <div class="crm-muted-card p-5">
                <p class="crm-subtext">Current role</p>
                <p class="crm-heading mt-2 text-2xl">{{ str($user->role)->headline() }}</p>
                <p class="crm-subtext mt-2">{{ $user->job_title }}</p>
            </div>
            <div class="mt-4 crm-muted-card p-5">
                <p class="crm-subtext">Theme preference</p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">Choose between light and dark workspace themes. The toggle in the navbar still lets you switch instantly.</p>
            </div>
        </x-ui.card>

        <x-ui.card title="Preferences" subtitle="Profile settings, notifications, and visual theme.">
            <form method="POST" action="{{ route('settings.update') }}" class="grid gap-4 md:grid-cols-2">
                @csrf
                @method('PATCH')
                <x-ui.input label="Name" name="name" :value="old('name', $user->name)" required />
                <x-ui.input label="Email" name="email" type="email" :value="old('email', $user->email)" required />
                <x-ui.input label="Phone" name="phone" :value="old('phone', $user->phone)" />
                <x-ui.input label="Job title" name="job_title" :value="old('job_title', $user->job_title)" />
                <div class="md:col-span-2">
                    <x-ui.select label="Theme" name="theme">
                        <option value="light" @selected(old('theme', $user->theme) === 'light')>Light</option>
                        <option value="dark" @selected(old('theme', $user->theme) === 'dark')>Dark</option>
                    </x-ui.select>
                </div>
                <div class="md:col-span-2 space-y-3 rounded-3xl border border-slate-200 p-5 dark:border-slate-800">
                    <p class="text-sm font-semibold text-slate-900 dark:text-white">Notification preferences</p>
                    @php($prefs = $user->notification_preferences ?? [])
                    <label class="flex items-center justify-between">
                        <span class="text-sm text-slate-600 dark:text-slate-300">Email updates</span>
                        <input type="checkbox" name="notification_preferences[email_updates]" value="1" @checked(old('notification_preferences.email_updates', $prefs['email_updates'] ?? false))>
                    </label>
                    <label class="flex items-center justify-between">
                        <span class="text-sm text-slate-600 dark:text-slate-300">Deal alerts</span>
                        <input type="checkbox" name="notification_preferences[deal_alerts]" value="1" @checked(old('notification_preferences.deal_alerts', $prefs['deal_alerts'] ?? false))>
                    </label>
                    <label class="flex items-center justify-between">
                        <span class="text-sm text-slate-600 dark:text-slate-300">Weekly summary</span>
                        <input type="checkbox" name="notification_preferences[weekly_summary]" value="1" @checked(old('notification_preferences.weekly_summary', $prefs['weekly_summary'] ?? false))>
                    </label>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="crm-btn-primary">Save settings</button>
                </div>
            </form>
        </x-ui.card>
    </div>
@endsection
