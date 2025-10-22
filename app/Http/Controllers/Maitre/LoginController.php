<?php

namespace App\Http\Controllers\Maitre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion
     * Route: GET /maitre/login
     */
    public function index()
    {
        return view('maitre.auth.login'); // Assure-toi que la vue existe : resources/views/maitre/login.blade.php
    }

    /**
     * Traite la tentative de connexion
     * Route: POST /maitre/login
     */
    public function login(Request $request)
    {
        // Validation du formulaire
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::guard('maitre')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('maitre.dashboard')); // Redirection vers le dashboard du maître
        }

        // Échec de la connexion
        return back()->withErrors([
            'email' => 'Ces identifiants ne correspondent pas à nos enregistrements.',
        ])->withInput($request->only('email'));
    }

    /**
     * Déconnexion
     * Route: POST /maitre/logout
     */
    public function logout(Request $request)
    {
        Auth::guard('maitre')->logout();             // Déconnecte le maître
        $request->session()->invalidate();           // Invalide la session
        $request->session()->regenerateToken();      // Regénère le token CSRF

        return redirect()->route('welcome');    // Redirection vers le login
    }
}
