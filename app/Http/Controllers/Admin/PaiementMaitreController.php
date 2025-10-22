<?php

namespace App\Http\Controllers\Admin;

use App\Models\Maitre;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use App\Models\PaiementMaitre;
use App\Http\Controllers\Controller;

class PaiementMaitreController extends Controller
{
    public function index(Request $request)
    {
        $annees = AnneeScolaire::all();
        $anneeId = $request->get('annee_scolaire_id');

        $paiements = PaiementMaitre::with(['maitre', 'anneeScolaire'])
            ->when($anneeId, function ($query) use ($anneeId) {
                $query->where('annee_scolaire_id', $anneeId);
            })
            ->orderBy('date_paiement', 'desc')
            ->get();

        return view('admin.paiement_maitres.index', compact('paiements', 'annees', 'anneeId'));
    }

    public function create()
    {
        $maitres = Maitre::all();
        $annees = AnneeScolaire::all();
        return view('admin.paiement_maitres.create', compact('maitres', 'annees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'maitre_id' => 'required|exists:maitres,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'mois' => 'required|string',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|string|in:Chèque,Espèce,Orange Money,Wave,Moov Money',
        ]);

        $maitre = Maitre::findOrFail($request->maitre_id);
        $validated['montant'] = $maitre->salaire;

        PaiementMaitre::create($validated);

        return redirect()->route('paiement-maitre.index')
            ->with('success', 'Paiement créé avec succès.');
    }

    public function edit($id)
    {
        $paiement = PaiementMaitre::findOrFail($id);
        $maitres = Maitre::all();
        $annees = AnneeScolaire::all();
        return view('admin.paiement_maitres.edit', compact('paiement', 'maitres', 'annees'));
    }

    public function update(Request $request)
    {
        $paiement = PaiementMaitre::findOrFail($request->id);

        $validated = $request->validate([
            'maitre_id' => 'required|exists:maitres,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'mois' => 'required|string',
            'date_paiement' => 'required|date',
            'mode_paiement' => 'required|string|in:Chèque,Espèce,Orange Money,Wave,Moov Money',
        ]);

        $maitre = Maitre::findOrFail($request->maitre_id);
        $validated['montant'] = $maitre->salaire;

        $paiement->update($validated);

        return redirect()->route('paiement-maitre.index')
            ->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $paiement = PaiementMaitre::findOrFail($id);
        $paiement->delete();

        return redirect()->route('paiement-maitre.index')
            ->with('success', 'Paiement supprimé avec succès.');
    }
}
