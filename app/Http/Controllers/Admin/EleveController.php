<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Tuteur;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use App\Http\Controllers\Controller;

class EleveController extends Controller
{
    /**
     * Affiche la liste des élèves
     */
    public function index(Request $request)
    {
        $classes = Classe::all();
        $annees = AnneeScolaire::all();

        // 🔹 Charger les élèves avec tuteur, classe et dernière inscription
        $query = Eleve::with([
            'tuteur',
            'classe',
            'inscriptions' => function ($q) {
                $q->orderByDesc('created_at')->limit(1);
            },
            'inscriptions.anneeScolaire',
        ]);

        // 🔹 Filtrer par classe si demandé
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // 🔹 Filtrer par année scolaire si demandé
        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('inscriptions', function ($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        $eleves = $query->latest()->get();

        return view('admin.eleves.index', compact('eleves', 'classes', 'annees'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        $classes = Classe::all();
        $tuteurs = Tuteur::all();
        return view('admin.eleves.create', compact('classes', 'tuteurs'));
    }

    /**
     * Enregistre un nouvel élève
     */
    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|unique:eleves,matricule',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'nom_pere' => 'nullable|string|max:255',
            'nom_mere' => 'nullable|string|max:255',
            'tuteur_id' => 'required|exists:tuteurs,id',
            'classe_id' => 'nullable|exists:classes,id',
            'statut' => 'required|in:actif,absent,abandon'
        ]);

        Eleve::create($request->all());

        return redirect()->route('eleve.index')->with('success', 'Élève ajouté avec succès.');
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id)
    {
        $eleve = Eleve::with(['tuteur', 'classe'])->findOrFail($id);
        $classes = Classe::all();
        $tuteurs = Tuteur::all();
        return view('admin.eleves.edit', compact('eleve', 'classes', 'tuteurs'));
    }

    /**
     * Met à jour un élève
     */
    public function update(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        $request->validate([
            'matricule' => 'required|unique:eleves,matricule,' . $eleve->id,
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F',
            'date_naissance' => 'nullable|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'nom_pere' => 'nullable|string|max:255',
            'nom_mere' => 'nullable|string|max:255',
            'tuteur_id' => 'required|exists:tuteurs,id',
            'classe_id' => 'nullable|exists:classes,id',
            'statut' => 'required|in:actif,absent,abandon'
        ]);

        $eleve->update($request->all());

        return redirect()->route('eleve.index')->with('success', 'Élève mis à jour avec succès.');
    }

    /**
     * Supprime un élève
     */
    public function delete($id)
    {
        $eleve = Eleve::findOrFail($id);
        $tuteur = $eleve->tuteur;

        $eleve->delete();

        // Vérifie si le tuteur n’a plus d’élèves, puis supprime-le
        if ($tuteur && $tuteur->eleves()->count() == 0) {
            $tuteur->delete();
        }

        return redirect()->route('eleve.index')->with('success', 'Élève et tuteur supprimés ils sont liés.');
    }
}
