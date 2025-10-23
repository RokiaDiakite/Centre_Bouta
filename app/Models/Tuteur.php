<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Tuteur extends Authenticatable
{
    protected $fillable = ['nom', 'prenom', 'numero', 'profession', 'adresse', 'username', 'password', 'email'];

    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'tuteur_id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
