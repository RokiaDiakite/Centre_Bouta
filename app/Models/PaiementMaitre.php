<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaiementMaitre extends Model
{
    use HasFactory;

    // Spécifier le nom exact de la table
    protected $table = 'paiements_maitres';

    protected $fillable = [
        'maitre_id',
        'annee_scolaire_id',
        'montant',
        'mois',
        'date_paiement',
        'mode_paiement'
    ];

    public function maitre()
    {
        return $this->belongsTo(Maitre::class);
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id');
    }
}
