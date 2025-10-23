<?php

namespace App\Http\Controllers\Tuteur;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Eleve;
use App\Models\EmploisDuTemps;

class DashboardController extends Controller
{
    public function index()
    {
        $tuteurId = Auth::id();

        // Nombre d'élèves du tuteur
        $eleves_count = Eleve::where('tuteur_id', $tuteurId)->count();

        // Nombre d'emplois du temps liés aux classes des élèves du tuteur
        $classe_ids = Eleve::where('tuteur_id', $tuteurId)->pluck('classe_id');
        $emplois_count = EmploisDuTemps::whereIn('classe_id', $classe_ids)->count();

        // Notifications désactivées pour l'instant
        $notifications_count = 0;

        return view('tuteur.dashboard', compact(
            'eleves_count',
            'emplois_count',
            'notifications_count'
        ));
    }
}
