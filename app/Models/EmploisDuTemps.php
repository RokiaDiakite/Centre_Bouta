<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploisDuTemps extends Model
{
    use HasFactory;

    protected $fillable = [
        'annee_scolaire_id', 'classe_id', 'jour', 'heure_debut', 'heure_fin',
        'matiere_id', 'maitre_id'
    ];

    public function classe() {
        return $this->belongsTo(Classe::class);
    }

    public function matiere() {
        return $this->belongsTo(Matiere::class);
    }

    public function maitre() {
        return $this->belongsTo(Maitre::class, 'maitre_id');
    }

    public function anneeScolaire() {
        return $this->belongsTo(AnneeScolaire::class);
    }
}
