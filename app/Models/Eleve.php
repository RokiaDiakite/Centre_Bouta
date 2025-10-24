<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'nom_pere',
        'nom_mere',
        'tuteur_id',
        'classe_id',
        'statut'
    ];

    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    public function derniereInscription()
    {
        return $this->hasOne(Inscription::class)->latestOfMany();
    }
    public function notes()
    {
        return $this->hasMany(\App\Models\Note::class);
    }
}
