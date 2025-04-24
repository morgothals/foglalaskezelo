<?php

namespace App\Livewire\Booking;

use App\Models\Service;
use App\Models\Hairdresser;
use Livewire\Component;

class Stepper extends Component
{
    public $services;
    public $hairdressers = [];

    public $selectedService = null;
    public $selectedHairdresser = null;

    public $clientName = '';
    public $clientEmail = '';
    public $clientPhone = '';
    public $acceptPolicy = false;
    public $saveDetails = false;

    public function mount()
    {
        $this->services = Service::all();
    }

    public function selectService($serviceId)
    {
        $this->selectedService = $serviceId;
        $this->hairdressers = Service::find($serviceId)?->hairdressers ?? [];
        $this->selectedHairdresser = null;
    }

    public function selectHairdresser($hairdresserId)
    {
        $this->selectedHairdresser = $hairdresserId;
    }

    public function onServiceSelected($value)
    {
        $this->selectedService = $value;
        $this->hairdressers = Service::find($value)?->hairdressers ?? [];
        $this->selectedHairdresser = null;
    }

    public function onHairdresserSelected($value)
    {
        $this->selectedHairdresser = $value;
    }

    public function submitAppointment()
    {
        $this->validate([
            'clientName' => 'required|string|max:255',
            'clientEmail' => 'required|email',
            'clientPhone' => 'required|string|max:20',
            'acceptPolicy' => 'accepted',
        ]);

        // Itt lehet menteni az adatokat az adatbázisba, például az Appointments táblába

        session()->flash('success', 'A foglalásod sikeresen rögzítve lett!');
        $this->reset(); // mezők törlése
    }

    public function render()
    {
        return view('livewire.booking.stepper');
    }
}
