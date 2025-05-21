<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $n) => Str::substr($n, 0, 1))
            ->implode('');
    }

    // Új: fodrászhoz kötött felhasználó
    public function hairdresser()
    {
        return $this->hasOne(Hairdresser::class, 'user_id', 'id');
    }
}
