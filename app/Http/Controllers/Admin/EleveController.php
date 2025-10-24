<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Tuteur;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use App\Http\Controllers\Controller;
use App\Models\Inscription;

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

    public function passation(){
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
         return view('admin.eleves.passation', compact('annees', 'classes'));
    }

    public function getEleves(Request $request)
{
   $eleves = Eleve::whereHas('inscriptions', function ($q) use ($request) {
                        $q->where('annee_id', $request->annee)
                          ->where('classe_id', $request->classe);
                    })
                    ->with(['classe'])
                    ->get()
                    ->map(function ($e) {
                        return [
                            'id' => $e->id,
                            'nom' => $e->nom,
                            'prenom' => $e->prenom,
                            'matricule' => $e->matricule,
                            'classe_nom' => $e->classe->nom ?? '-',
                        ];
                    });

        return response()->json($eleves);
                }
public function fairePasser($id)
    {
        $eleve = Eleve::findOrFail($id);
        $inscription = $eleve->inscriptions()->latest('annee_id')->first();

        if (!$inscription) {
            return response()->json(['message' => 'Aucune inscription trouvée pour cet élève.'], 404);
        }

        // Trouver l'année suivante
        $anneeSuivante = AnneeScolaire::where('id', '>', $inscription->annee_id)->orderBy('id')->first();

        if (!$anneeSuivante) {
            return response()->json(['message' => 'Aucune année scolaire suivante trouvée.'], 404);
        }

        // Trouver la classe suivante
        $classeSuivante = Classe::where('niveau', '>', $inscription->classe->niveau)
                                ->orderBy('niveau')
                                ->first();

        if (!$classeSuivante) {
            return response()->json(['message' => 'Aucune classe supérieure trouvée.'], 404);
        }

        // Vérifier si l'élève n'est pas déjà inscrit dans la nouvelle année
        $existe = Inscription::where('eleve_id', $eleve->id)
                             ->where('annee_id', $anneeSuivante->id)
                             ->exists();

        if ($existe) {
            return response()->json(['message' => 'Cet élève est déjà inscrit pour l’année suivante.']);
        }

        // Créer la nouvelle inscription
        Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $classeSuivante->id,
            'annee_id' => $anneeSuivante->id,
            'statut' => 'inscrit',
        ]);

        return response()->json(['message' => 'Élève reconduit avec succès dans la nouvelle année !']);
    }
}
