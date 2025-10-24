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

        $query = Eleve::query();

        // Si aucun filtre ni recherche => ne rien afficher
        if (!$request->filled('search') && !$request->filled('classe_id') && !$request->filled('annee_scolaire_id')) {
            return view('admin.eleves.index', [
                'eleves' => collect([]), // liste vide
                'classes' => $classes,
                'annees' => $annees,
            ]);
        }

        // 🔍 Recherche par nom, prénom ou matricule
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        // 🎓 Filtre par classe
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // 🏫 Filtre par année scolaire (si tu as un lien avec inscriptions)
        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('derniereInscription', function ($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        $eleves = $query->orderBy('nom')->get();

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

    public function show($id){
         $eleve = Eleve::with(['tuteur', 'classe'])->findOrFail($id);
        return view('admin.eleves.show', compact('eleve'));
    }
}
