<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
    ];

    // Egy ügyfél több időpontot is foglalhat
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'customer_id', 'customer_id');
    }
}
