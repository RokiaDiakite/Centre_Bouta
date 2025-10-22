<?php

namespace App\Http\Controllers\Maitre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PaiementMaitre;

class PaiementMaitreController extends Controller
{
    // ✅ Affiche tous les paiements du maître connecté
    public function index()
    {
        $maitreId = Auth::guard('maitre')->id();

        $paiements = PaiementMaitre::with('anneeScolaire')
            ->where('maitre_id', $maitreId)
            ->orderBy('date_paiement', 'desc')
            ->get();

        return view('maitre.paiement_maitres.index', compact('paiements'));
    }

    // ✅ Affiche un paiement spécifique appartenant au maître connecté
    public function show($id)
    {
        $maitreId = Auth::guard('maitre')->id();

        $paiement = PaiementMaitre::with(['anneeScolaire'])
            ->where('maitre_id', $maitreId)
            ->findOrFail($id);

        return view('maitre.paiement_maitres.show', compact('paiement'));
    }
}
