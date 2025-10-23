<?php

namespace App\Http\Controllers\Tuteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Affiche les infos du tuteur connecté
    public function index()
    {
        $tuteur = Auth::guard('tuteur')->user();
        return view('tuteur.profils.index', compact('tuteur'));
    }

    // Formulaire d'édition du profil
    public function edit()
    {
        $tuteur = Auth::guard('tuteur')->user();
        return view('tuteur.profils.edit', compact('tuteur'));
    }

    // Mise à jour du profil
    public function update(Request $request)
    {
        $tuteur = Auth::guard('tuteur')->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tuteurs,username,' . $tuteur->id,
            'email' => 'required|email|max:255|unique:tuteurs,email,' . $tuteur->id,
            'numero' => 'nullable|string|max:20',
            'profession' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $tuteur->update([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'username' => $request->username,
            'email' => $request->email,
            'numero' => $request->numero,
            'profession' => $request->profession,
            'adresse' => $request->adresse,
        ]);

        if ($request->filled('password')) {
            $tuteur->password = Hash::make($request->password);
            $tuteur->save();
        }

        return redirect()->route('tuteur.profile.index')->with('success', 'Profil mis à jour avec succès !');
    }
}
