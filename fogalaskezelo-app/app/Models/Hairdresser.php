<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hairdresser extends Model
{
    use HasFactory;

    protected $primaryKey = 'hairdresser_id'; // mert nem "id" a kulcs neve

    // Egy fodrásznak több szolgáltatása lehet
    public function services()
    {
        return $this->belongsToMany(Service::class, 'hairdresser_services', 'hairdresser_id', 'service_id');
    }

    // Egy fodrásznak több értékelése lehet
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'hairdresser_id', 'hairdresser_id');
    }

    // Egy fodrásznak több időpontfoglalása lehet
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'hairdresser_id', 'hairdresser_id');
    }
}
