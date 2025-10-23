<?php

namespace App\Http\Controllers\Tuteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Eleve;
use App\Models\FraisScolaire;
use Illuminate\Support\Facades\Auth;

class FraisScolaireController extends Controller
{
    // Liste des élèves dont le tuteur est responsable
    public function index()
    {
        $tuteurId = Auth::id(); // ID du tuteur connecté
        $eleves = Eleve::where('tuteur_id', $tuteurId)
            ->with('classe')
            ->get();

        return view('tuteur.frais_scolaire.index', compact('eleves'));
    }

    // Voir les paiements d'un élève spécifique
    public function show($eleveId)
    {
        $tuteurId = Auth::id();

        $eleve = Eleve::where('id', $eleveId)
            ->where('tuteur_id', $tuteurId)
            ->with('classe')
            ->firstOrFail();

        $paiements = FraisScolaire::where('eleve_id', $eleve->id)
            ->get();

        return view('tuteur.frais_scolaire.show', compact('eleve', 'paiements'));
    }
}
