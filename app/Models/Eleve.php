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
        return $this->belongsTo(Tuteur::class, 'tuteur_id')->withDefault();
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'eleve_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function fraisScolaires()
    {
        return $this->hasMany(FraisScolaire::class, 'eleve_id');
    }
    protected static function booted()
    {
        static::deleting(function ($eleve) {
            // Supprimer les inscriptions de cet élève
            $eleve->inscriptions()->delete();

            // Supprimer le tuteur associé
            if ($eleve->tuteur) {
                $eleve->tuteur->delete();
            }
        });
    }
}
