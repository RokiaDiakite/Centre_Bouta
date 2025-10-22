<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    protected $fillable = ['libelle', 'statut'];

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
}
