<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Note, Eleve, Classe, Matiere, Evaluation, AnneeScolaire};
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Liste des notes
    public function index(Request $request)
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::all();
        $evaluations = Evaluation::all();

        $notes = [];

        if ($request->filled(['annee_id', 'classe_id', 'matiere_id', 'evaluation_id'])) {
            $notes = Note::with(['eleve', 'matiere'])
                ->where('matiere_id', $request->matiere_id)
                ->where('evaluation_id', $request->evaluation_id)
                ->whereHas('eleve.inscriptions', function ($q) use ($request) {
                    $q->where('classe_id', $request->classe_id)
                        ->where('annee_scolaire_id', $request->annee_id);
                })
                ->get();
        }

        return view('admin.notes.index', compact('annees', 'classes', 'matieres', 'notes', 'evaluations'));
    }

    // Formulaire pour ajouter une note individuelle
    public function create()
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::all();
        $evaluations = Evaluation::all();

        return view('admin.notes.create', compact('annees', 'classes', 'matieres', 'evaluations'));
    }

    // Enregistrement d'une note individuelle
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'annee_id' => 'required|exists:annee_scolaires,id',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'evaluation_id' => 'required|exists:evaluations,id',
            'note_devoir' => 'nullable|numeric|min:0|max:20',
            'note_evaluation' => 'nullable|numeric|min:0|max:20',
        ]);

        $note->update([
            'annee_scolaire_id' => $request->annee_id,
            'classe_id' => $request->classe_id,
            'matiere_id' => $request->matiere_id,
            'evaluation_id' => $request->evaluation_id,
            'note_devoir' => $request->note_devoir,
            'note_evaluation' => $request->note_evaluation,
        ]);

        return redirect()->route('note.index')->with('success', 'Note mise à jour avec succès.');
    }


    // Formulaire et enregistrement des notes par classe
    public function createClasse()
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::all();
        $evaluations = Evaluation::all();

        return view('admin.notes.create-classe', compact('annees', 'classes', 'matieres', 'evaluations'));
    }

    public function updateClasse(Request $request, Classe $classe, AnneeScolaire $annee)
    {
        $request->validate([
            'notes' => 'required|array',
        ]);

        foreach ($request->notes as $eleve_id => $matiereNotes) {
            foreach ($matiereNotes as $matiere_id => $vals) {
                Note::updateOrCreate(
                    [
                        'eleve_id' => $eleve_id,
                        'classe_id' => $classe->id,
                        'annee_scolaire_id' => $annee->id,
                        'matiere_id' => $matiere_id,
                    ],
                    [
                        'evaluation_id' => $request->evaluation_id ?? 1,
                        'note_devoir' => isset($vals['cc']) ? floatval(str_replace(',', '.', $vals['cc'])) : null,
                        'note_evaluation' => isset($vals['evaluation']) ? floatval(str_replace(',', '.', $vals['evaluation'])) : null,
                        // On ne stocke pas le coefficient
                    ]
                );
            }
        }

        return redirect()->route('note.index')->with('success', 'Notes mises à jour avec succès.');
    }

    // Fiche de notes filtrée
    public function fiche(Request $request)
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        $matieres = Matiere::all();
        $evaluations = Evaluation::all();
        $notes = [];

        if ($request->filled(['annee_id', 'classe_id', 'matiere_id', 'evaluation_id'])) {
            $notes = Note::with(['eleve', 'matiere'])
                ->where('annee_scolaire_id', $request->annee_id)
                ->where('classe_id', $request->classe_id)
                ->where('matiere_id', $request->matiere_id)
                ->where('evaluation_id', $request->evaluation_id)
                ->get();

            $annee = AnneeScolaire::findOrFail($request->annee_id);
            $classe = Classe::findOrFail($request->classe_id);
            $matiere = Matiere::findOrFail($request->matiere_id);
            $evaluation = Evaluation::findOrFail($request->evaluation_id);
        }


        return view('admin.notes.index', compact('annees', 'classes', 'matieres', 'notes', 'evaluations', 'annee', 'classe', 'matiere', 'evaluation'));
    }

    // Liste des élèves pour une classe (JSON)
    public function getElevesByClasse($classe_id)
    {
        $eleves = Eleve::whereHas('inscriptions', function ($query) use ($classe_id) {
            $query->where('classe_id', $classe_id);
        })
            ->select('id', 'nom', 'prenom')
            ->orderBy('nom')
            ->get();

        return response()->json($eleves);
    }
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('note.index')->with('success', 'Note supprimée avec succès.');
    }
    public function edit(Note $note)
    {
        $annees = \App\Models\AnneeScolaire::all();
        $classes = \App\Models\Classe::all();
        $matieres = \App\Models\Matiere::all();
        $evaluations = \App\Models\Evaluation::all();

        return view('admin.notes.edit', compact('note', 'annees', 'classes', 'matieres', 'evaluations'));
    }
}
