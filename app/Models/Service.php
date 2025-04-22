<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $primaryKey = 'service_id';

    // Egy szolgáltatást több fodrász is kínálhat
    public function hairdressers()
    {
        return $this->belongsToMany(Hairdresser::class, 'hairdresser_services', 'service_id', 'hairdresser_id');
    }

    // Egy szolgáltatást több foglalásban is lefoglalhatnak
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'service_id', 'service_id');
    }
}
