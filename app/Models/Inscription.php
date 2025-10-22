<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_inscrip',
        'eleve_id',
        'annee_scolaire_id',
        'classe_id',
        'frais_ins'
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id')->withDefault();
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
