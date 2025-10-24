<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Tuteur;
use App\Models\Inscription;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::all();
        $annees = AnneeScolaire::all();

        $query = Inscription::with(['eleve.tuteur', 'classe', 'anneeScolaire']);

        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        if ($request->filled('annee_scolaire_id')) {
            $query->where('annee_scolaire_id', $request->annee_scolaire_id);
        }

        $inscriptions = $query->latest()->get();
        return view('admin.inscriptions.index', compact('inscriptions', 'classes', 'annees'));
    }

    public function create()
    {
        $classes = Classe::all();
        $annees = AnneeScolaire::all();
        return view('admin.inscriptions.create', compact('classes', 'annees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'eleve_nom' => 'required',
            'eleve_prenom' => 'required',
            'eleve_date_naissance' => 'required|date',
            'eleve_sexe' => 'required',
            'tuteur_email' => 'required|email|unique:tuteurs,email',
            'tuteur_password' => 'required|min:6',
            'classe_id' => 'required|exists:classes,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'frais_ins' => 'required|numeric|min:0',
        ]);

        // Création du tuteur
        $tuteur = Tuteur::create([
            'nom' => $request->tuteur_nom,
            'prenom' => $request->tuteur_prenom,
            'email' => $request->tuteur_email,
            'password' => Hash::make($request->tuteur_password),
            'adresse' => $request->tuteur_adresse,
            'numero' => $request->tuteur_numero,
            'username' => $request->tuteur_username,
            'profession' => $request->tuteur_profession,
        ]);

        // Génération du matricule MAT0000 à 1000
        $lastId = Eleve::max('id') ?? 0;
        $matricule = 'MAT' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        // Création de l’élève
        $eleve = Eleve::create([
            'matricule' => $matricule,
            'nom' => $request->eleve_nom,
            'prenom' => $request->eleve_prenom,
            'date_naissance' => $request->eleve_date_naissance,
            'lieu_naissance' => $request->eleve_lieu_naissance,
            'adresse' => $request->eleve_adresse,
            'nom_pere' => $request->eleve_nom_pere,
            'nom_mere' => $request->eleve_nom_mere,
            'sexe' => $request->eleve_sexe,
            'statut' => $request->eleve_statut,
            'tuteur_id' => $tuteur->id,
            'classe_id' => $request->classe_id,
        ]);

        // Création de l’inscription
        Inscription::create([
            'eleve_id' => $eleve->id,
            'classe_id' => $request->classe_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'frais_ins' => $request->frais_ins,
            'date_inscrip' => now(),
        ]);

        return redirect()->route('inscription.index')->with('success', 'Inscription ajoutée.');
    }

    public function edit($id)
    {
        $inscription = Inscription::with('eleve.tuteur')->findOrFail($id);
        $classes = Classe::all();
        $annees = AnneeScolaire::all();
        return view('admin.inscriptions.edit', compact('inscription', 'classes', 'annees'));
    }

    public function update(Request $request, $id)
    {
        $inscription = Inscription::with('eleve.tuteur')->findOrFail($id);

        $tuteur = $inscription->eleve->tuteur;
        $tuteur->update([
            'nom' => $request->tuteur_nom,
            'prenom' => $request->tuteur_prenom,
            'email' => $request->tuteur_email,
            'adresse' => $request->tuteur_adresse,
            'numero' => $request->tuteur_numero,
            'username' => $request->tuteur_username,
            'profession' => $request->tuteur_profession,
            'password' => $request->filled('tuteur_password') ? Hash::make($request->tuteur_password) : $tuteur->password,
        ]);

        $eleve = $inscription->eleve;
        $eleve->update([
            'nom' => $request->eleve_nom,
            'prenom' => $request->eleve_prenom,
            'date_naissance' => $request->eleve_date_naissance,
            'lieu_naissance' => $request->eleve_lieu_naissance,
            'adresse' => $request->eleve_adresse,
            'nom_pere' => $request->eleve_nom_pere,
            'nom_mere' => $request->eleve_nom_mere,
            'sexe' => $request->eleve_sexe,
            'statut' => $request->eleve_statut,
        ]);

        $inscription->update([
            'classe_id' => $request->classe_id,
            'annee_scolaire_id' => $request->annee_scolaire_id,
            'frais_ins' => $request->frais_ins,
        ]);

        return redirect()->route('inscription.index')->with('success', 'Inscription modifiée.');
    }

    public function delete($id)
    {
        $inscription = Inscription::findOrFail($id);
        $inscription->delete(); // Supprime élève + tuteur via booted()
        return redirect()->route('inscription.index')->with('success', 'Inscription supprimée.');
    }
}
