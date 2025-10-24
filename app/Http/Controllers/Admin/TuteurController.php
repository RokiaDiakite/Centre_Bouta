<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tuteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TuteurController extends Controller
{
    /**
     * Afficher la liste des tuteurs
     */
    public function index()
    {
        $tuteurs = Tuteur::all();
        return view('admin.tuteurs.index', compact('tuteurs'));
    }

    /**
     * Afficher le formulaire d’ajout
     */
    public function create()
    {
        return view('admin.tuteurs.create');
    }

    /**
     * Enregistrer un nouveau tuteur
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'         => 'required|string',
            'prenom'      => 'required|string',
            'email'       => 'required|email|unique:tuteurs,email',
            'username'    => 'required|string',
            'password'    => 'required|string|min:6',
            'adresse'     => 'nullable|string',
            'numero'      => 'nullable|string',
            'profession'  => 'nullable|string',
        ]);

        Tuteur::create([
            'nom'        => $request->nom,
            'prenom'     => $request->prenom,
            'email'      => $request->email,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'adresse'    => $request->adresse,
            'numero'     => $request->numero,
            'profession' => $request->profession,
        ]);

        return redirect()->route('tuteur.index')->with('success', 'Tuteur ajouté avec succès.');
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit($id)
    {
        $tuteur = Tuteur::findOrFail($id);
        return view('admin.tuteurs.edit', compact('tuteur'));
    }

    /**
     * Mettre à jour un tuteur (✅ version sans $id en paramètre)
     */
    public function update(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:tuteurs,id',
            'nom'         => 'required|string',
            'prenom'      => 'required|string',
            'email'       => 'required|email|unique:tuteurs,email,' . $request->id,
            'username'    => 'required|string',
            'adresse'     => 'nullable|string',
            'numero'      => 'nullable|string',
            'profession'  => 'nullable|string',
            'password'    => 'nullable|string|min:6',
        ]);

        $tuteur = Tuteur::findOrFail($request->id);

        $tuteur->nom        = $request->nom;
        $tuteur->prenom     = $request->prenom;
        $tuteur->email      = $request->email;
        $tuteur->username   = $request->username;
        $tuteur->adresse    = $request->adresse;
        $tuteur->numero     = $request->numero;
        $tuteur->profession = $request->profession;

        // Mot de passe : ne le change que si le champ est rempli
        if (!empty($request->password)) {
            $tuteur->password = Hash::make($request->password);
        }

        $tuteur->save();

        return redirect()->route('tuteur.index')->with('success', 'Tuteur mis à jour avec succès.');
    }

    /**
     * Supprimer un tuteur
     */
    public function destroy($id)
    {
        $tuteur = Tuteur::findOrFail($id);
        $tuteur->delete();

        return redirect()->route('tuteur.index')->with('success', 'Tuteur supprimé avec succès.');
    }

     public function show($id){
         $tuteur = Tuteur::findOrFail($id);
        return view('admin.tuteurs.show', compact('tuteur'));
    }
}
