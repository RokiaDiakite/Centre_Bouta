<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseMaitreMatiere extends Model
{
    protected $fillable = ['classe_id', 'maitre_id', 'matiere_id', 'titulaire'];
}
