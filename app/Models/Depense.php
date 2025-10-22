<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = [
        'annee_scolaire_id',
        'date',
        'intitule',
        'montant',
        'fichier_pdf'
    ];
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }
}
