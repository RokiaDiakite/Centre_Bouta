<?php

namespace App\Http\Controllers\Tuteur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmploisDuTemps;
use App\Models\Eleve;
use Illuminate\Support\Facades\Auth;
use PDF;

class EmploisDuTempsController extends Controller
{
    // Liste des élèves dont le tuteur est responsable
    public function index()
    {
        $tuteurId = Auth::id();
        $eleves = Eleve::where('tuteur_id', $tuteurId)->get();

        return view('tuteur.emploi_du_temps.index', compact('eleves'));
    }

    // Voir l'emploi du temps d'un élève spécifique
    public function show($eleveId)
    {
        $tuteurId = Auth::id();

        $eleve = Eleve::where('id', $eleveId)
            ->where('tuteur_id', $tuteurId)
            ->firstOrFail();

        $emplois = EmploisDuTemps::where('classe_id', $eleve->classe_id)
            ->with(['matiere', 'maitre'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();

        return view('tuteur.emploi_du_temps.show', compact('eleve', 'emplois'));
    }

    // Télécharger l'emploi du temps en PDF
    public function download($eleveId)
    {
        $tuteurId = Auth::id();

        $eleve = Eleve::where('id', $eleveId)
            ->where('tuteur_id', $tuteurId)
            ->firstOrFail();

        $emplois = EmploisDuTemps::where('classe_id', $eleve->classe_id)
            ->with(['matiere', 'maitre'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get();

        $pdf = PDF::loadView('tuteur.emploi_du_temps.pdf', compact('eleve', 'emplois'));
        return $pdf->download('Emploi_du_temps_' . $eleve->nom . '.pdf');
    }
}
