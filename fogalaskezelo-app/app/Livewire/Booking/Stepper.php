<?php

namespace App\Livewire\Booking;

use App\Mail\BookingConfirmation;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use App\Models\Customer;
use App\Models\Hairdresser;
use App\Models\Service;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Stepper extends Component
{
    public $services;
    public $hairdressers = [];

    public $selectedService = null;
    public $selectedHairdresser = null;

    public $availabilitySlots = [];
    public $selectedSlot = null;

    public $clientName = '';
    public $clientEmail = '';
    public $clientPhone = '';
    public $acceptPolicy = false;
    public $saveDetails = false;

    public $successMessage = '';

    protected $rules = [
        'clientName'   => 'required|string|max:255',
        'clientEmail'  => 'required|email',
        'clientPhone'  => 'required|string|max:20',
        'acceptPolicy' => 'accepted',
    ];

    public function mount()
    {
        $this->services = Service::all();
    }

    public function onServiceSelected($serviceId)
    {
        $this->selectedService = $serviceId;
        $this->hairdressers = Service::find($serviceId)?->hairdressers ?? [];
        $this->selectedHairdresser = null;
        $this->availabilitySlots = [];
        $this->selectedSlot = null;
        $this->successMessage = '';
    }

    public function onHairdresserSelected($hairdresserId)
    {
        $this->selectedHairdresser = $hairdresserId;
        $hairdresser = Hairdresser::find($hairdresserId);
        $this->availabilitySlots = $hairdresser
            ? $hairdresser->availabilitySlots()->orderBy('start_time')->get()
            : [];
        $this->selectedSlot = null;
        $this->successMessage = '';
    }

    public function onSlotSelected($slotId)
    {
        $this->selectedSlot = $slotId;
        $this->successMessage = '';
    }

    public function submitAppointment()
    {
        $this->validate();

        // Ügyfél lekérése vagy létrehozása e-mail alapján
        $customer = Customer::firstOrCreate(
            ['email' => $this->clientEmail],
            ['name' => $this->clientName, 'phone_number' => $this->clientPhone]
        );

        // 2) Appointment létrehozása
        $slot = AvailabilitySlot::findOrFail($this->selectedSlot);

        $appointment = Appointment::create([
            'customer_id'      => $customer->customer_id,
            'hairdresser_id'   => $this->selectedHairdresser,
            'service_id'       => $this->selectedService,
            'appointment_time' => $slot->start_time,
            'status'           => 'confirmed',
        ]);

        // Lefoglalt sáv törlése
        $slot->delete();

        //  Email küldése a kliensnek
        $serviceName     = Service::find($this->selectedService)->name;
        $hairdresserName = Hairdresser::find($this->selectedHairdresser)->name;

        $emailData = [
            'clientName'      => $customer->name,
            'date'            => $appointment->appointment_time->format('Y-m-d'),
            'time'            => $appointment->appointment_time->format('H:i'),
            'serviceName'     => $serviceName,
            'hairdresserName' => $hairdresserName,
            'notes'           => null,
        ];

        Mail::to($customer->email)
            ->send(new BookingConfirmation($emailData));

        //Siker-üzenet
        $this->successMessage = 'A foglalásod sikeresen rögzítve lett, és megerősítő e-mailt küldtünk!';

        //Űrlap törlése (de sikerüzenet megmarad)
        $this->reset([
            'selectedService',
            'selectedHairdresser',
            'availabilitySlots',
            'selectedSlot',
            'clientName',
            'clientEmail',
            'clientPhone',
            'acceptPolicy',
            'saveDetails',
        ]);
        $this->mount();


        $this->dispatch('scrollToTop');
    }

    public function render()
    {
        return view('livewire.booking.stepper');
    }
}
