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
        return $this->belongsTo(Eleve::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    protected static function booted()
    {
        static::deleting(function ($inscription) {
            if ($inscription->eleve) {
                $inscription->eleve->tuteur?->delete();
                $inscription->eleve->delete();
            }
        });
    }
}
