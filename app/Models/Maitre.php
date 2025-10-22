<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maitre extends Authenticatable
{
    protected $fillable = ['nom', 'prenom', 'numero', 'adresse', 'salaire', 'username', 'password', 'email'];

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_maitre_matieres')
            ->withPivot('matiere_id', 'titulaire');
    }

    public function paiements()
    {
        return $this->hasMany(PaiementMaitre::class);
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploisDuTemps::class, 'enseignant_id');
    }
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
