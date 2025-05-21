<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilitySlot extends Model
{
    use HasFactory;

    protected $primaryKey = 'slot_id';

    protected $fillable = [
        'hairdresser_id',
        'start_time',
        'end_time',
    ];

    /**
     * A sávhoz tartozó fodrász.
     */
    public function hairdresser()
    {
        return $this->belongsTo(Hairdresser::class, 'hairdresser_id', 'hairdresser_id');
    }
}
