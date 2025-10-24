<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Affiche les infos du profil
    public function index()
    {
        $user = Auth::user();
        return view('admin.profils.index', compact('user'));
    }

    // Formulaire de modification du profil
    public function show()
    {
        $user = Auth::user();
        return view('admin.profils.show', compact('user'));
    }

    // Mise à jour du profil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('uploads/photos/admin'), $photoName);
            $user->photo = 'uploads/photos/admin/' . $photoName;
        }

        $user->save();

        return redirect()->route('admin.profile.index')->with('success', 'Profil mis à jour avec succès.');
    }
}
