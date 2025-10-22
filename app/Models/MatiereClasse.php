<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatiereClasse extends Model
{
    protected $fillable = ['classe_id', 'matiere_id'];
    // Relation vers Classe
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    // Relation vers Matiere
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
}
