<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraisScolaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'classe_id',
        'annee_scolaire_id',
        'montant_total',
        'montant_paye',
        'reliquat',
        'date_paiement',
        'mode_de_paiement',
        'fichier_pdf',
        'numero_recu',
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
}
