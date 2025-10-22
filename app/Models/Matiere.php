<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = ['nom', 'coefficient'];

    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'matiere_classes', 'matiere_id', 'classe_id');
    }


    public function notes()
    {
        return $this->hasMany(Note::class, 'matiere_id'); // corrigé
    }



    public function emploiDuTemps()
    {
        return $this->hasMany(EmploisDuTemps::class);
    }
}
