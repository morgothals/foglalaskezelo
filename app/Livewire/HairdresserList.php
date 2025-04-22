<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Hairdresser;

class HairdresserList extends Component
{
    public $hairdressers;

    public function mount()
    {
        // Lekérjük az összes fodrászt a kapcsolódó szolgáltatásokkal együtt
        $this->hairdressers = Hairdresser::with('services')->get();
    }

    public function render()
    {
        return view('livewire.hairdresser-list');
    }
}
