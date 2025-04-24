<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $primaryKey = 'rating_id';

    // Egy értékelés egy fodrászhoz tartozik
    public function hairdresser()
    {
        return $this->belongsTo(Hairdresser::class, 'hairdresser_id', 'hairdresser_id');
    }
}
