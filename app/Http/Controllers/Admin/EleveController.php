<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Tuteur;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EleveController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::all();
        $annees  = AnneeScolaire::all();

        $query = Eleve::with(['tuteur', 'classe', 'inscriptions.anneeScolaire']);

        // Filtrer par classe si sélectionnée
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }

        // Filtrer par année scolaire si sélectionnée
        if ($request->filled('annee_scolaire_id')) {
            $query->whereHas('inscriptions', function ($q) use ($request) {
                $q->where('annee_scolaire_id', $request->annee_scolaire_id);
            });
        }

        $eleves = $query->get();

        return view('admin.eleves.index', compact('eleves', 'classes', 'annees'));
    }




    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $tuteurs = Tuteur::all();
        $classes = Classe::all();
        return view('admin.eleves.create', compact('tuteurs', 'classes'));
    }

    /**
     * Ajouter un nouvel élève avec son tuteur
     */
    public function store(Request $request)
    {
        $request->validate([
            // Tuteur
            'tuteur_nom'      => 'required|string',
            'tuteur_prenom'   => 'required|string',
            'tuteur_email'    => 'required|email|unique:tuteurs,email',
            'tuteur_password' => 'required|string|min:6',
            'tuteur_adresse'  => 'nullable|string',
            'tuteur_numero'   => 'nullable|string',
            'tuteur_username'   => 'nullable|string',
            'tuteur_profession'   => 'nullable|string',
            // Eleve
            'eleve_nom'            => 'required|string',
            'eleve_prenom'         => 'required|string',
            'eleve_date_naissance' => 'required|date',
            'eleve_lieu_naissance' => 'required|string',
            'eleve_nom_pere' => 'required|string',
            'eleve_nom_mere' => 'required|string',
            'eleve_sexe' => 'required|string',
            'eleve_adresse'        => 'nullable|string',
            'eleve_statut' => 'required|string',
            'classe_id'            => 'required|exists:classes,id',
        ]);

        DB::beginTransaction();

        try {
            // Création du tuteur
            $tuteur = Tuteur::create([
                'nom'      => $request->tuteur_nom,
                'prenom'   => $request->tuteur_prenom,
                'email'    => $request->tuteur_email,
                'username'   => $request->tuteur_username,
                'password' => Hash::make($request->tuteur_password),
                'adresse'  => $request->tuteur_adresse,
                'numero'   => $request->tuteur_numero,
                'profession'   => $request->tuteur_profession,

            ]);

            // Création de l'élève
            $eleve = Eleve::create([
                'matricule'      => 'MAT' . rand(0000, 9999),
                'nom'            => $request->eleve_nom,
                'prenom'         => $request->eleve_prenom,
                'date_naissance' => $request->eleve_date_naissance,
                'lieu_naissance' => $request->eleve_lieu_naissance,
                'nom_pere'            => $request->eleve_nom_pere,
                'nom_mere'            => $request->eleve_nom_mere,
                'sexe'            => $request->eleve_sexe,
                'statut'            => $request->eleve_statut,
                'adresse'        => $request->eleve_adresse,
                'tuteur_id'      => $tuteur->id,
                'classe_id'      => $request->classe_id, // ✅ ajout obligatoire
            ]);



            DB::commit();

            return redirect()->route('eleve.index')
                ->with('success', 'Élève ajouté avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l’ajout de l’élève : ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $eleve = Eleve::findOrFail($id);
        $tuteurs = Tuteur::all();
        $classes = Classe::all();

        return view('admin.eleves.edit', compact('eleve', 'tuteurs', 'classes'));
    }


    /**
     * Mettre à jour un élève
     */
    public function update(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        $request->validate([
            'tuteur_id'      => 'required|exists:tuteurs,id',
            'classe_id'      => 'required|exists:classes,id',
            'nom'            => 'required|string',
            'prenom'         => 'required|string',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'required|string',
            'adresse'        => 'nullable|string',
            'nom_pere'       => 'required|string',
            'nom_mere'       => 'required|string',
            'eleve_sexe'   => 'required|in:M,F',
            'eleve_statut' => 'required|in:actif,absent,abandon',

        ]);

        $eleve->update([
            'tuteur_id'      => $request->tuteur_id,
            'classe_id'      => $request->classe_id,
            'nom'            => $request->nom,
            'prenom'         => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'adresse'        => $request->adresse,
            'nom_pere'            => $request->nom_pere,
            'nom_mere'            => $request->nom_mere,
            'sexe'   => $request->eleve_sexe,
            'statut' => $request->eleve_statut,

        ]);

        return redirect()->route('eleve.index')
            ->with('success', 'Élève mis à jour avec succès.');
    }

    /**
     * Supprimer un élève
     */
    public function destroy($id)
    {
        $eleve = Eleve::findOrFail($id);
        $eleve->delete();

        return redirect()->route('eleve.index')
            ->with('success', 'Élève supprimé avec succès.');
    }
}
