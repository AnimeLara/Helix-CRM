<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/leads-export', [LeadController::class, 'export'])->name('leads.export');
    Route::resource('leads', LeadController::class)->except(['create', 'edit']);
    Route::resource('customers', CustomerController::class)->except(['create', 'edit']);
    Route::resource('deals', DealController::class)->except(['create', 'edit']);
    Route::patch('/deals/{deal}/stage', [DealController::class, 'updateStage'])->name('deals.stage');
    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);
    Route::patch('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', [SettingsController::class, 'edit'])
        ->middleware('role:admin,manager')
        ->name('settings.edit');
    Route::patch('/settings', [SettingsController::class, 'update'])
        ->middleware('role:admin,manager')
        ->name('settings.update');
});

require __DIR__.'/auth.php';
