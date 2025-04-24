<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\Service;

class ServicesSection extends Component
{
    public $services = [];

    public function mount()
    {
        $grouped = Service::with('hairdressers')
            ->get()
            ->groupBy('name')
            ->map(function ($group) {
                $minPrice = $group->flatMap(function ($service) {
                    return $service->hairdressers->pluck('pivot.price');
                })->min();

                return [
                    'name' => $group->first()->name,
                    'min_price' => $minPrice,
                ];
            });

        $this->services = $grouped->values()->all();
    }

    public function render()
    {
        return view('livewire.booking.services-section');
    }
}
