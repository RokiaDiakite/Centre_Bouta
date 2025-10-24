<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\FraisScolaire;
use App\Models\Depense;
use App\Models\PaiementMaitre;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1️⃣ Charger toutes les années scolaires
        $anneesScolaires = AnneeScolaire::orderBy('id', 'desc')->get();

        // 2️⃣ Année sélectionnée ou dernière par défaut
        $anneeScolaireId = $request->get('annee_scolaire_id');
        $annee = $anneeScolaireId
            ? AnneeScolaire::find($anneeScolaireId)
            : $anneesScolaires->first();

        // 3️⃣ Année précédente
        $anneeReference = AnneeScolaire::where('id', '<', $annee->id)
            ->orderBy('id', 'desc')
            ->first();

        // 4️⃣ Classes et initialisation
        $classes = Classe::all();
        $statsParClasse = [];

        $totalEleves = 0;
        $nbGarcons = 0;
        $nbFilles = 0;
        $totalChiffreAffaires = 0;
        $totalMontantPaye = 0;

        // 💰 Paiements et dépenses global pour l’année
        $totalPaiementMaitre = PaiementMaitre::where('annee_scolaire_id', $annee->id)->sum('montant');
        $totalDepense = Depense::where('annee_scolaire_id', $annee->id)->sum('montant');

        foreach ($classes as $classe) {
            // Inscriptions pour la classe et l’année
            $inscriptions = Inscription::with('eleve')
                ->where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $annee->id)
                ->get();

            $nbTotal = $inscriptions->count();
            $garcons = $inscriptions->filter(fn($i) => $i->eleve && $i->eleve->sexe === 'M')->count();
            $filles = $inscriptions->filter(fn($i) => $i->eleve && $i->eleve->sexe === 'F')->count();

            // Chiffre d’affaires attendu = frais de la classe × nombre d’élèves
            $chiffreAffaires = $classe->frais * $nbTotal;

            // Montant payé pour la classe
            $montantPaye = FraisScolaire::where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $annee->id)
                ->sum('montant_paye');

            // Reliquat = chiffre d’affaires - montant payé
            $reliquat = $chiffreAffaires - $montantPaye;

            $statsParClasse[] = [
                'nom' => $classe->nom,
                'total' => $nbTotal,
                'garcons' => $garcons,
                'filles' => $filles,
                'chiffreAffaires' => $chiffreAffaires,
                'montantPaye' => $montantPaye,
                'reliquat' => $reliquat,
                'paiementMaitre' => $totalPaiementMaitre,
                'depense' => $totalDepense,
            ];

            // Cumuls globaux
            $totalEleves += $nbTotal;
            $nbGarcons += $garcons;
            $nbFilles += $filles;
            $totalChiffreAffaires += $chiffreAffaires;
            $totalMontantPaye += $montantPaye;
        }

        // Totaux globaux
        $totaux = [
            'nbEleves' => $totalEleves,
            'chiffreAffaires' => $totalChiffreAffaires,
            'montantPaye' => $totalMontantPaye,
            'reliquat' => $totalChiffreAffaires - $totalMontantPaye,
            'paiementMaitre' => $totalPaiementMaitre,
            'depense' => $totalDepense,
        ];

        // Taux de recouvrement
        $tauxRecouvrement = $totalChiffreAffaires > 0
            ? round(($totalMontantPaye / $totalChiffreAffaires) * 100, 2)
            : 0;

        // Comparaison avec l’année précédente
        $comparaison = [
            'nbEleves' => 0,
            'chiffreAffaires' => 0,
        ];

        if ($anneeReference) {
            $elevesAnneePrec = Inscription::where('annee_scolaire_id', $anneeReference->id)->count();

            $chiffreAffairesPrec = 0;
            foreach (Classe::all() as $classePrec) {
                $nbPrec = Inscription::where('classe_id', $classePrec->id)
                    ->where('annee_scolaire_id', $anneeReference->id)
                    ->count();
                $chiffreAffairesPrec += $classePrec->frais * $nbPrec;
            }

            $comparaison['nbEleves'] = $elevesAnneePrec > 0
                ? round(($totalEleves / $elevesAnneePrec) * 100, 2)
                : 100;

            $comparaison['chiffreAffaires'] = $chiffreAffairesPrec > 0
                ? round(($totalChiffreAffaires / $chiffreAffairesPrec) * 100, 2)
                : 100;
        }

        // Graphiques
        $sexeChartData = [
            'labels' => ['Garçons', 'Filles'],
            'data' => [$nbGarcons, $nbFilles],
        ];

        $financeChartData = [
            'labels' => ['Chiffre d’affaires', 'Montant payé', 'Dépenses'],
            'data' => [$totalChiffreAffaires, $totalMontantPaye, $totalDepense],
        ];

        $classeChartData = [
            'labels' => array_column($statsParClasse, 'nom'),
            'data' => array_column($statsParClasse, 'total'),
        ];

        return view('admin.dashboard', compact(
            'anneesScolaires',
            'annee',
            'anneeReference',
            'statsParClasse',
            'totaux',
            'nbGarcons',
            'nbFilles',
            'comparaison',
            'tauxRecouvrement',
            'sexeChartData',
            'financeChartData',
            'classeChartData'
        ));
    }
}
