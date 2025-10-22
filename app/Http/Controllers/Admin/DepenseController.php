<?php

namespace App\Http\Controllers\Admin;

use App\Models\Depense;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        $anneeId = $request->get('annee_scolaire_id');
        $annees = AnneeScolaire::all();

        $query = Depense::with('anneeScolaire')->orderBy('date', 'desc');
        if ($anneeId) {
            $query->where('annee_scolaire_id', $anneeId);
        }
        $depenses = $query->get();

        return view('admin.depenses.index', compact('depenses', 'annees', 'anneeId'));
    }

    public function create()
    {
        $annees = AnneeScolaire::all();
        return view('admin.depenses.create', compact('annees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date' => 'required|date',
            'intitule' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'fichier_pdf' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',
        ]);

        if ($request->hasFile('fichier_pdf')) {
            $validated['fichier_pdf'] = $request->file('fichier_pdf')->store('depenses_pdfs', 'public');
        }

        Depense::create($validated);

        return redirect()->route('depense.index')->with('success', 'Dépense ajoutée avec succès.');
    }

    public function edit($id)
    {
        $depense = Depense::findOrFail($id);
        $annees = AnneeScolaire::all();
        return view('admin.depenses.edit', compact('depense', 'annees'));
    }

    public function update(Request $request)
    {
        $depense = Depense::findOrFail($request->id);

        $validated = $request->validate([
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'date' => 'required|date',
            'intitule' => 'required|string|max:255',
            'montant' => 'required|numeric',
            'fichier_pdf' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:4096',
        ]);

        if ($request->hasFile('fichier_pdf')) {
            if ($depense->fichier_pdf && Storage::disk('public')->exists($depense->fichier_pdf)) {
                Storage::disk('public')->delete($depense->fichier_pdf);
            }
            $validated['fichier_pdf'] = $request->file('fichier_pdf')->store('depenses_pdfs', 'public');
        }

        $depense->update($validated);

        return redirect()->route('depense.index')->with('success', 'Dépense mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $depense = Depense::findOrFail($id);
        if ($depense->fichier_pdf && Storage::disk('public')->exists($depense->fichier_pdf)) {
            Storage::disk('public')->delete($depense->fichier_pdf);
        }
        $depense->delete();

        return redirect()->route('depense.index')->with('success', 'Dépense supprimée avec succès.');
    }
}
