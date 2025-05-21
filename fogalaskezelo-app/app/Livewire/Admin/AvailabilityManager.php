<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AvailabilitySlot;
use App\Models\Appointment;
use Carbon\Carbon;

class AvailabilityManager extends Component
{
    public $date;
    public $start_time;
    public $end_time;

    protected $rules = [
        'date'       => 'required|date|after_or_equal:today',
        'start_time' => 'required',
        'end_time'   => 'required|after:start_time',
    ];

    public function render()
    {
        // Elérhetőségi sávok
        $slots = auth()->user()
            ->hairdresser
            ->availabilitySlots()
            ->orderBy('start_time')
            ->get();

        // Foglalások
        $appointments = auth()->user()
            ->hairdresser
            ->appointments()
            ->with(['customer', 'service'])
            ->orderBy('appointment_time')
            ->get();

        return view('livewire.admin.availability-manager', [
            'availabilitySlots' => $slots,
            'appointments'      => $appointments,
        ]);
    }

    public function store()
    {
        $this->validate();

        $start = Carbon::parse("{$this->date} {$this->start_time}");
        $end = Carbon::parse("{$this->date} {$this->end_time}");

        while ($start->lt($end)) {
            AvailabilitySlot::create([
                'hairdresser_id' => auth()->user()->hairdresser->hairdresser_id,
                'start_time'     => $start,
                'end_time'       => $start->copy()->addMinutes(45),
            ]);
            $start->addMinutes(45);
        }

        $this->reset(['date', 'start_time', 'end_time']);
    }

    public function destroy($slotId)
    {
        $slot = AvailabilitySlot::findOrFail($slotId);
        $this->authorize('delete', $slot);
        $slot->delete();
    }
}
