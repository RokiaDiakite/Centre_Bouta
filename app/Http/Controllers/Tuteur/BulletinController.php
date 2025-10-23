<?php

namespace App\Http\Controllers\Tuteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\Evaluation;
use App\Models\Note;

class BulletinController extends Controller
{
    // Liste des enfants du tuteur
    public function index()
    {
        $tuteur = Auth::guard('tuteur')->user();
        $eleves = $tuteur->eleves; // Relation: tuteur a plusieurs eleves

        return view('tuteur.bulletins.index', compact('eleves'));
    }

    // Affichage du bulletin d'un enfant
    public function show($eleve_id)
    {
        $tuteur = Auth::guard('tuteur')->user();
        $eleve = $tuteur->eleves()->where('id', $eleve_id)->first();

        if (!$eleve) {
            return redirect()->route('tuteur.bulletin.index')->with('info', 'Élève introuvable.');
        }

        // Récupération des notes
        $notes = Note::where('eleve_id', $eleve->id)->get()->keyBy('matiere_id');

        // Récupération des matières de la classe
        $matieres = $eleve->classe->matieres ?? collect();

        if ($matieres->isEmpty() || $notes->isEmpty()) {
            return redirect()->route('tuteur.bulletin.index')->with('info', 'Pas de bulletin encore disponible pour cet élève.');
        }

        // Calcul des moyennes et appréciations
        $totalPondere = 0;
        $sommeCoef = 0;
        $appreciationsMatiere = [];

        foreach ($matieres as $matiere) {
            $note = $notes[$matiere->id] ?? null;
            $coef = $matiere->coefficient ?? 1;
            $devoir = floatval($note->note_devoir ?? 0);
            $evalNote = floatval($note->note_evaluation ?? 0);
            $moyenneMatiere = ($devoir + 2 * $evalNote) / 3;

            $totalPondere += $moyenneMatiere * $coef;
            $sommeCoef += $coef;

            if ($moyenneMatiere >= 16) $appreciationsMatiere[$matiere->id] = 'Excellent';
            elseif ($moyenneMatiere >= 14) $appreciationsMatiere[$matiere->id] = 'Très bien';
            elseif ($moyenneMatiere >= 12) $appreciationsMatiere[$matiere->id] = 'Bien';
            elseif ($moyenneMatiere >= 10) $appreciationsMatiere[$matiere->id] = 'Passable';
            else $appreciationsMatiere[$matiere->id] = 'Insuffisant';
        }

        $moyenneGenerale = $sommeCoef ? $totalPondere / $sommeCoef : 0;

        // Calcul du rang dans la classe
        $elevesClasse = $eleve->classe->eleves ?? collect();
        $moyennesClasse = [];
        foreach ($elevesClasse as $el) {
            $notesEl = Note::where('eleve_id', $el->id)->get()->keyBy('matiere_id');
            $totalEl = 0;
            $coefEl = 0;
            foreach ($matieres as $matiere) {
                $note = $notesEl[$matiere->id] ?? null;
                $coef = $matiere->coefficient ?? 1;
                $devoir = floatval($note->note_devoir ?? 0);
                $evalNote = floatval($note->note_evaluation ?? 0);
                $moy = ($devoir + 2 * $evalNote) / 3;
                $totalEl += $moy * $coef;
                $coefEl += $coef;
            }
            $moyennesClasse[$el->id] = $coefEl ? $totalEl / $coefEl : 0;
        }

        arsort($moyennesClasse);
        $rang = array_search($eleve->id, array_keys($moyennesClasse)) + 1;

        // Appréciation générale
        $appreciation = match (true) {
            $moyenneGenerale < 10 => "Insuffisant",
            $moyenneGenerale < 12 => "Passable",
            $moyenneGenerale < 14 => "Assez bien",
            $moyenneGenerale < 16 => "Bien",
            default => "Très bien",
        };

        // Proverbe aléatoire
        $proverbes = [
            "L’éducation est l’arme la plus puissante pour changer le monde.",
            "La réussite appartient à ceux qui persévèrent.",
            "Ne rêve pas ta vie, vis tes rêves.",
            "Petit à petit, l’oiseau fait son nid.",
            "Chaque jour est une chance d’apprendre quelque chose.",
        ];
        $proverbe = $proverbes[array_rand($proverbes)];

        return view('tuteur.bulletins.show', compact(
            'eleve',
            'matieres',
            'notes',
            'appreciationsMatiere',
            'moyenneGenerale',
            'rang',
            'appreciation',
            'proverbe'
        ));
    }

    // Télécharger PDF
    public function download($eleve_id)
    {
        $tuteur = Auth::guard('tuteur')->user();
        $eleve = $tuteur->eleves()->where('id', $eleve_id)->first();

        if (!$eleve) {
            return redirect()->route('tuteur.bulletin.index')->with('info', 'Élève introuvable.');
        }

        $notes = Note::where('eleve_id', $eleve->id)->get()->keyBy('matiere_id');
        $matieres = $eleve->classe->matieres ?? collect();

        if ($matieres->isEmpty() || $notes->isEmpty()) {
            return redirect()->route('tuteur.bulletin.index')->with('info', 'Pas de bulletin encore disponible pour cet élève.');
        }

        // Reprend calcul des moyennes & appréciation
        $totalPondere = 0;
        $sommeCoef = 0;
        $appreciationsMatiere = [];
        foreach ($matieres as $matiere) {
            $note = $notes[$matiere->id] ?? null;
            $coef = $matiere->coefficient ?? 1;
            $devoir = floatval($note->note_devoir ?? 0);
            $evalNote = floatval($note->note_evaluation ?? 0);
            $moyenneMatiere = ($devoir + 2 * $evalNote) / 3;
            $totalPondere += $moyenneMatiere * $coef;
            $sommeCoef += $coef;

            if ($moyenneMatiere >= 16) $appreciationsMatiere[$matiere->id] = 'Excellent';
            elseif ($moyenneMatiere >= 14) $appreciationsMatiere[$matiere->id] = 'Très bien';
            elseif ($moyenneMatiere >= 12) $appreciationsMatiere[$matiere->id] = 'Bien';
            elseif ($moyenneMatiere >= 10) $appreciationsMatiere[$matiere->id] = 'Passable';
            else $appreciationsMatiere[$matiere->id] = 'Insuffisant';
        }

        $moyenneGenerale = $sommeCoef ? $totalPondere / $sommeCoef : 0;

        $appreciation = match (true) {
            $moyenneGenerale < 10 => "Insuffisant",
            $moyenneGenerale < 12 => "Passable",
            $moyenneGenerale < 14 => "Assez bien",
            $moyenneGenerale < 16 => "Bien",
            default => "Très bien",
        };

        $pdf = Pdf::loadView('tuteur.bulletins.pdf', compact(
            'eleve',
            'matieres',
            'notes',
            'appreciationsMatiere',
            'moyenneGenerale',
            'appreciation'
        ));

        return $pdf->download('bulletin_' . $eleve->nom . '_' . $eleve->prenom . '.pdf');
    }
}
