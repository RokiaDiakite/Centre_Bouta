<?php

namespace App\Http\Controllers\Admin;

use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Maitre;
use App\Models\Depense;
use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use App\Models\FraisScolaire;
use App\Models\PaiementMaitre;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $anneeId = $request->input('annee_scolaire_id');

        // Charger toutes les années scolaires pour le filtre
        $anneesScolaires = AnneeScolaire::all();

        // Si une année scolaire est sélectionnée
        $elevesIds = $anneeId
            ? Inscription::where('annee_scolaire_id', $anneeId)->pluck('eleve_id')
            : Eleve::pluck('id');

        // Statistiques globales
        $totalEleves = Eleve::whereIn('id', $elevesIds)->count();
        $totalProfs = Maitre::count();
        $totalPaiements = FraisScolaire::when($anneeId, fn($q) => $q->where('annee_scolaire_id', $anneeId))->sum('montant_paye');
        $totalDepenses = Depense::when($anneeId, fn($q) => $q->where('annee_scolaire_id', $anneeId))->sum('montant');
        $totalPaiementsMaitres = PaiementMaitre::when($anneeId, fn($q) => $q->where('annee_scolaire_id', $anneeId))->sum('montant');

        // Répartition garçons/filles
        $nbGarcons = Eleve::whereIn('id', $elevesIds)->where('sexe', 'M')->count();
        $nbFilles = Eleve::whereIn('id', $elevesIds)->where('sexe', 'F')->count();

        // Statistiques par classe
        $statsParClasse = Classe::select('id', 'nom')->get()->map(function ($classe) use ($anneeId) {
            $elevesClasse = Inscription::where('classe_id', $classe->id)
                ->when($anneeId, fn($q) => $q->where('annee_scolaire_id', $anneeId))
                ->pluck('eleve_id');

            $garcons = Eleve::whereIn('id', $elevesClasse)->where('sexe', 'M')->count();
            $filles = Eleve::whereIn('id', $elevesClasse)->where('sexe', 'F')->count();

            return [
                'id' => $classe->id,
                'nom' => $classe->nom,
                'total' => $elevesClasse->count(),
                'garcons' => $garcons,
                'filles' => $filles,
            ];
        });

        return view('admin.dashboard', compact(
            'anneesScolaires',
            'anneeId',
            'totalEleves',
            'totalProfs',
            'totalPaiements',
            'totalDepenses',
            'totalPaiementsMaitres',
            'nbGarcons',
            'nbFilles',
            'statsParClasse'
        ));
    }
}
