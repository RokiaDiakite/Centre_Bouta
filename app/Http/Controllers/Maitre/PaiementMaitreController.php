<?php

namespace App\Http\Controllers\Maitre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaiementMaitre;

class PaiementMaitreController extends Controller
{
    // Liste des paiements du maître connecté
    public function index()
    {
        $maitreId = Auth::guard('maitre')->id();

        $paiements = PaiementMaitre::with('anneeScolaire')
            ->where('maitre_id', $maitreId)
            ->orderBy('date_paiement', 'desc')
            ->get();

        return view('maitre.paiements.index', compact('paiements'));
    }
}
