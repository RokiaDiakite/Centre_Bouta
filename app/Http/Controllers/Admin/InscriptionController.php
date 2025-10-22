<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Tuteur;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        // Récupération des données pour les filtres
        $classes = Classe::all();
        $annees  = AnneeScolaire::all();

        // Requête principale
        $query = Inscription::with(['eleve', 'classe', 'anneeScolaire']);

        // Application des filtres si présents
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        $inscriptions = $query->get();

        return view('admin.inscriptions.index', compact('inscriptions', 'classes', 'annees'));
    }


    public function create()
    {
        $classes = Classe::all();
        $annees  = AnneeScolaire::all();
        return view('admin.inscriptions.create', compact('classes', 'annees'));
    }
    // Créer une inscription individuelle pour un élève existant
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
            // Élève
            'eleve_nom'       => 'required|string',
            'eleve_prenom'    => 'required|string',
            'eleve_date_naissance' => 'required|date',
            'eleve_lieu_naissance' => 'nullable|string',
            'eleve_adresse'   => 'nullable|string',
            'eleve_nom_pere' => 'required|string',
            'eleve_nom_mere' => 'required|string',
            'eleve_sexe' => 'required|in:M,F',
            'eleve_statut' => 'required|in:actif,absent,abandon',

            // Inscription
            'classe_id'       => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',

            'frais_ins' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Création du tuteur
            $tuteur = Tuteur::create([
                'nom'      => $request->tuteur_nom,
                'prenom'   => $request->tuteur_prenom,
                'username'   => $request->tuteur_username,
                'email'    => $request->tuteur_email,
                'password' => Hash::make($request->tuteur_password),
                'adresse'  => $request->tuteur_adresse,
                'profession'   => $request->tuteur_profession,
                'numero'   => $request->tuteur_numero,
            ]);

            // Création de l'élève
            $eleve = Eleve::create([
                'matricule'      => 'MAT' . rand(1000, 9999),
                'nom'            => $request->eleve_nom,
                'prenom'         => $request->eleve_prenom,
                'date_naissance' => $request->eleve_date_naissance,
                'lieu_naissance' => $request->eleve_lieu_naissance,
                'adresse'        => $request->eleve_adresse,
                'tuteur_id'      => $tuteur->id,
                'nom_pere'            => $request->eleve_nom_pere,
                'nom_mere'            => $request->eleve_nom_mere,
                'sexe'            => $request->eleve_sexe,
                'statut'            => $request->eleve_statut,
                'classe_id'      => $request->classe_id, // ✅ AJOUT ICI
            ]);


            // Création de l'inscription
            // Création de l'inscription
            $inscription = Inscription::create([
                'date_inscrip'      => now(),
                'eleve_id'         => $eleve->id,
                'classe_id'         => $request->classe_id,
                'annee_scolaire_id' => $request->annee_scolaire_id,
                'frais_ins'         => $request->frais_ins, // ✅ ajouté
            ]);


            DB::commit();
            return redirect()->route('inscription.index')
                ->with('success', 'Inscription réussie !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l’inscription : ' . $e->getMessage());
        }
    }
    public function edit($id)

    {

        $inscription = Inscription::with('eleve.tuteur')->findOrFail($id);

        $classes     = Classe::all();

        $annees      = AnneeScolaire::all();

        return view('admin.inscriptions.edit', compact('inscription', 'classes', 'annees'));
    }


    // Mettre à jour une inscription
    public function update(Request $request, $id)

    {

        $inscription = Inscription::findOrFail($id);

        $request->validate([

            'classe_id'        => 'required|exists:classes,id',

            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',

        ]);

        $inscription->update([

            'classe_id'         => $request->classe_id,

            'annee_scolaire_id' => $request->annee_scolaire_id,

        ]);

        return redirect()->route('inscription.index')

            ->with('success', 'Inscription mise à jour avec succès.');
    }



    // Supprimer une inscription
    public function destroy($id)
    {
        $inscription = Inscription::findOrFail($id);

        DB::beginTransaction();
        try {
            // Supprimer l'élève et le tuteur via la cascade
            if ($inscription->eleve) {
                $inscription->eleve->delete();
            }

            // Supprimer l'inscription elle-même
            $inscription->delete();

            DB::commit();
            return redirect()->route('inscription.index')
                ->with('success', 'Inscription, élève et tuteur supprimés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
