<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Admin\Dashboard;
use Illuminate\Support\Facades\Route;

Route::get('home', function () {
    return view('home');
})->name('home');

Route::get('/', function () {
    return view('home');
});

Route::get('/foglalasok', function () {
    return view('booking');
});

Route::get('/idopontfoglalas', function () {
    return view('appointment');
});

Route::get('/debug-can', function () {
    $user = auth('web')->user();
    return [
        'role'  => $user->role,
        'can'   => $user->can('access-admin'),
        'gates' => Gate::abilities(),
    ];
})->middleware('auth');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth', 'can:access-admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/', Dashboard::class)->name('admin.dashboard'); // <-- Livewire komponens
        Route::get('availability', \App\Livewire\Admin\AvailabilityManager::class)
            ->name('admin.availability.index');
    });

require __DIR__ . '/auth.php';
