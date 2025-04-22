<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HairdresserService extends Model
{
    use HasFactory;

    protected $table = 'hairdresser_services';
    public $timestamps = false; // ebben a táblában nincs created_at/updated_at

    protected $fillable = ['hairdresser_id', 'service_id'];
}
