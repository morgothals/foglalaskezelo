<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\AvailabilitySlot;
use App\Models\Appointment;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        AvailabilitySlot::class => \App\Policies\AvailabilitySlotPolicy::class,
        Appointment::class      => \App\Policies\AppointmentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

       
        Gate::define('access-admin', fn($user) => $user->role === 'hairdresser');
    }
}