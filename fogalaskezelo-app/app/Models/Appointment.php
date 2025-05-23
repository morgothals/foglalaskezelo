<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $primaryKey = 'appointment_id';
    protected $casts = [
        'appointment_time' => 'datetime',
    ];

    protected $fillable = [
        'customer_id',
        'hairdresser_id',
        'service_id',
        'appointment_time',
        'status',
    ];


    // Egy foglalás egy ügyfélhez tartozik
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    // Egy foglalás egy fodrászhoz tartozik
    public function hairdresser()
    {
        return $this->belongsTo(Hairdresser::class, 'hairdresser_id', 'hairdresser_id');
    }

    // Egy foglalás egy szolgáltatáshoz tartozik
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}