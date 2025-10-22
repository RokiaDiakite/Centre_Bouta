<?php

namespace App\Http\Controllers\Maitre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EmploisDuTemps;

class EmploisDuTempsController extends Controller
{
    // Affiche l'emploi du temps du maître connecté
    public function index()
    {
        $maitreId = Auth::guard('maitre')->id();

        $emplois = EmploisDuTemps::with(['classe', 'matiere'])
            ->where('maitre_id', $maitreId)
            ->get();

        return view('maitre.emplois_du_temps.index', compact('emplois'));
    }

    // Affiche le détail d'un créneau spécifique (optionnel)
    public function show($id)
    {
        $maitreId = Auth::guard('maitre')->id();

        $emploi = EmploisDuTemps::with(['classe', 'matiere'])
            ->where('maitre_id', $maitreId)
            ->findOrFail($id);

        return view('maitre.emplois_du_temps.show', compact('emploi'));
    }
    public function print()
    {
        $maitreId = Auth::guard('maitre')->id();
        $maitre = Auth::guard('maitre')->user();

        $emplois = EmploisDuTemps::with(['classe', 'matiere', 'anneeScolaire'])
            ->where('maitre_id', $maitreId)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('maitre.emplois_du_temps.print', compact('emplois', 'maitre'));
        return $pdf->download('maitre.emploi_du_temps.pdf');
    }
}
