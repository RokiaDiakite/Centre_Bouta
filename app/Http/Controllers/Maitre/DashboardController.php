<?php

namespace App\Http\Controllers\Maitre;

use Illuminate\Http\Request;
use App\Models\EmploisDuTemps;
use App\Http\Controllers\Controller;
use App\Models\Maitre;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupère l'ID du maître connecté
        $maitreId = Auth::id();

        // Si tu veux récupérer tous les emplois du temps associés à ce maître :
        $emplois_count = EmploisDuTemps::where('maitre_id', $maitreId)->count();

        // Retourne la vue avec les données
        return view('maitre.dashboard', compact('emplois_count'));
    }
}
