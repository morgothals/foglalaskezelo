<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layout')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'hairdresser' => Auth::user(),
        ]);
    }
}
