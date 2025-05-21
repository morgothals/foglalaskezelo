<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hairdresser extends Model
{
    use HasFactory;

    protected $primaryKey = 'hairdresser_id';

    // Új: kapcsolat a felhasználóval
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'hairdresser_services', 'hairdresser_id', 'service_id')
            ->withPivot('price');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'hairdresser_id', 'hairdresser_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'hairdresser_id', 'hairdresser_id');
    }

    // Új: elérhetőségi sávok reláció
    public function availabilitySlots()
    {
        return $this->hasMany(AvailabilitySlot::class, 'hairdresser_id', 'hairdresser_id');
    }
}
