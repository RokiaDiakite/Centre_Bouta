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
    public function index(Request $request)
    {
        $classes = Classe::all();
        $annees = AnneeScolaire::all();

        $query = Eleve::query();

        if (!$request->filled('search') && !$request->filled('classe_id') && !$request->filled('annee_scolaire_id')) {
            return view('admin.eleves.index', [
                'eleves' => collect([]), 
                'classes' => $classes,
                'annees' => $annees,
            ]);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%")
                    ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('derniereInscription', function ($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        $eleves = $query->orderBy('nom')->get();

        return view('admin.eleves.index', compact('eleves', 'classes', 'annees'));
    }


    public function create()
    {
        $classes = Classe::all();
        $tuteurs = Tuteur::all();
        return view('admin.eleves.create', compact('classes', 'tuteurs'));
    }

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

    public function edit($id)
    {
        $eleve = Eleve::with(['tuteur', 'classe'])->findOrFail($id);
        $classes = Classe::all();
        $tuteurs = Tuteur::all();
        return view('admin.eleves.edit', compact('eleve', 'classes', 'tuteurs'));
    }

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

    public function delete($id)
    {
        $eleve = Eleve::findOrFail($id);
        $tuteur = $eleve->tuteur;

        $eleve->delete();

        if ($tuteur && $tuteur->eleves()->count() == 0) {
            $tuteur->delete();
        }

        return redirect()->route('eleve.index')->with('success', 'Élève et tuteur supprimés ils sont liés.');
    }

    public function show($id)
    {
        $eleve = Eleve::with(['tuteur', 'classe'])->findOrFail($id);
        return view('admin.eleves.show', compact('eleve'));
    }

    public function passation()
    {
        $annees = AnneeScolaire::all();
        $classes = Classe::all();
        return view('admin.eleves.passation', compact('annees', 'classes'));
    }

    public function getEleves(Request $request)
    {
        $anneeId = $request->input('annee');
        $classeId = $request->input('classe');

        if (!$anneeId || !$classeId) {
            return response()->json([]);
        }

        $eleves = Eleve::whereHas('inscriptions', function ($q) use ($anneeId, $classeId) {
            $q->where('annee_scolaire_id', $anneeId)
                ->where('classe_id', $classeId);
        })
            ->with('classe')
            ->get()
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'nom' => $e->nom,
                    'prenom' => $e->prenom,
                    'matricule' => $e->matricule,
                    'classe_nom' => optional($e->classe)->nom ?? '-',
                ];
            });

        return response()->json($eleves);
    }

    public function fairePasser($id)
    {
        $eleve = Eleve::findOrFail($id);
        $inscription = $eleve->inscriptions()->latest('annee_scolaire_id')->first();

        if (!$inscription) {
            return response()->json(['message' => 'Aucune inscription trouvée pour cet élève.'], 404);
        }

        $anneeSuivante = AnneeScolaire::where('id', '>', $inscription->annee_scolaire_id)
            ->orderBy('id')
            ->first();

        if (!$anneeSuivante) {
            return response()->json(['message' => 'Aucune année scolaire suivante trouvée.'], 404);
        }

        $classeSuivante = Classe::where('niveau_ordre', '>', $inscription->classe->niveau_ordre)
            ->orderBy('niveau_ordre')
            ->first();

        if (!$classeSuivante) {
            return response()->json(['message' => 'L’élève est déjà dans la classe la plus élevée.'], 404);
        }

        $existe = Inscription::where('eleve_id', $eleve->id)
            ->where('annee_scolaire_id', $anneeSuivante->id)
            ->exists();

        if ($existe) {
            return response()->json(['message' => 'Cet élève est déjà inscrit pour l’année suivante.']);
        }

        Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $classeSuivante->id,
            'annee_scolaire_id' => $anneeSuivante->id,
            'statut' => 'inscrit',
        ]);

        return response()->json(['message' => 'Élève reconduit avec succès dans la nouvelle année !']);
    }
}
