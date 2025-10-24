<?php

namespace App\Http\Controllers\Maitre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // ✅ Affiche les infos du maître connecté
    public function index()
    {
        $maitre = Auth::guard('maitre')->user();
        return view('maitre.profils.index', compact('maitre'));
    }

    // ✅ Formulaire d’édition du profil
    public function edit()
    {
        $maitre = Auth::guard('maitre')->user();
        return view('maitre.profils.edit', compact('maitre'));
    }

    // ✅ Mise à jour du profil
    public function update(Request $request)
    {
        $maitre = Auth::guard('maitre')->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:maitres,username,' . $maitre->id,
            'email' => 'required|email|max:255|unique:maitres,email,' . $maitre->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $maitre->nom = $request->nom;
        $maitre->prenom = $request->prenom;
        $maitre->username = $request->username;
        $maitre->email = $request->email;

        if ($request->filled('password')) {
            $maitre->password = Hash::make($request->password);
        }
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/photos/maitre'), $photoName);
            $maitre->photo = 'uploads/photos/maitre/' . $photoName;
        }
        $maitre->save();

        return redirect()->route('maitre.profile.index')->with('success', 'Profil mis à jour avec succès !');
    }
}
