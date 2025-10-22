<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $fillable = ['nom', 'niveau', 'frais'];

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'matiere_classes', 'classe_id', 'matiere_id');
    }


    public function maitres()
    {
        return $this->belongsToMany(Maitre::class, 'classe_maitre_matieres')
            ->withPivot('matiere_id', 'titulaire');
    }

    public function emploisDuTemps()
    {
        return $this->hasMany(EmploisDuTemps::class);
    }
}
