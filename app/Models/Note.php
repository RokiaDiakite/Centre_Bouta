<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'classe_id',
        'eleve_id',
        'matiere_id',
        'evaluation_id',
        'annee_scolaire_id',
        'note_devoir',
        'note_evaluation',
        'coefficient',
    ];

    // 🔥 Hook automatique : chaque fois qu'une note est enregistrée ou mise à jour
    protected static function booted()
    {
        static::saving(function ($note) {
            if ($note->matiere_id) {
                $matiere = \App\Models\Matiere::find($note->matiere_id);
                if ($matiere && isset($matiere->coefficient)) {
                    $note->coefficient = $matiere->coefficient;
                } else {
                    $note->coefficient = 1;
                }
            }
        });
    }

    // --- Relations ---
    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
    public function anneeScolaire()
    {
        return $this->belongsTo(AnneeScolaire::class);
    }
}
