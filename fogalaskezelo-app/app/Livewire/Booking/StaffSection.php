<?php

namespace App\Livewire\Booking;

use App\Models\Hairdresser;
use Livewire\Component;

class StaffSection extends Component
{
    public function render()
    {
        return view('livewire.booking.staff-section', [
            'hairdressers' => Hairdresser::with('ratings')->get()
        ]);
    }
}
