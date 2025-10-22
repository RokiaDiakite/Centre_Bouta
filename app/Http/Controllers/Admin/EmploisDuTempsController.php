<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Maitre;
use App\Models\Matiere;
use App\Models\AnneeScolaire;
use App\Models\EmploisDuTemps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;

class EmploisDuTempsController extends Controller
{
    public function index()
    {
        $emplois = EmploisDuTemps::with(['classe', 'matiere', 'maitre'])->get();
        return view('admin.emplois_du_temps.index', compact('emplois'));
    }

    public function create()
    {
        $classes = Classe::all();
        $matieres = Matiere::all();
        $maitres = Maitre::all();
        $annees = AnneeScolaire::all();
        return view('admin.emplois_du_temps.create', compact('classes', 'matieres', 'maitres', 'annees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'maitre_id' => 'required|exists:maitres,id',
            'jour' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        EmploisDuTemps::create($request->all());
        return redirect()->route('emploi.index')->with('success', 'Créneau ajouté avec succès');
    }

    public function edit($id)
    {
        $edt = EmploisDuTemps::findOrFail($id);
        $classes = Classe::all();
        $matieres = Matiere::all();
        $maitres = Maitre::all();
        $annees = AnneeScolaire::all();
        return view('admin.emplois_du_temps.edit', compact('edt', 'classes', 'matieres', 'maitres', 'annees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'classe_id' => 'required|exists:classes,id',
            'matiere_id' => 'required|exists:matieres,id',
            'maitre_id' => 'required|exists:maitres,id',
            'jour' => 'required',
            'heure_debut' => 'required',
            'heure_fin' => 'required',
        ]);

        $emploi = EmploisDuTemps::findOrFail($id);
        $emploi->update($request->all());

        return redirect()->route('emploi.index')->with('success', 'Créneau mis à jour avec succès');
    }

    public function destroy($id)
    {
        $emploi = EmploisDuTemps::findOrFail($id);
        $emploi->delete();
        return redirect()->route('emploi.index')->with('success', 'Créneau supprimé');
    }

    public function selectClasse()
    {
        $classes = Classe::all();
        return view('admin.emplois_du_temps.select-classe', compact('classes'));
    }

    public function selectMaitre()
    {
        $maitres = Maitre::all();
        return view('admin.emplois_du_temps.select-maitre', compact('maitres'));
    }

    public function showByClasse($id)
    {
        $classe = Classe::findOrFail($id);
        $emplois = EmploisDuTemps::with(['matiere', 'maitre'])
            ->where('classe_id', $id)
            ->get();

        return view('admin.emplois_du_temps.show_by_classe', compact('classe', 'emplois'));
    }

    public function showByMaitre($id)
    {
        $maitre = Maitre::findOrFail($id);
        $emplois = EmploisDuTemps::with(['classe', 'matiere'])
            ->where('maitre_id', $id)
            ->get();

        return view('admin.emplois_du_temps.show_by_maitre', compact('maitre', 'emplois'));
    }
    // PDF pour une classe
    public function printClasse($id)
    {
        $classe = Classe::findOrFail($id);
        $emplois = EmploisDuTemps::with(['matiere', 'maitre'])
            ->where('classe_id', $id)
            ->get();

        $pdf = Pdf::loadView('admin.emplois_du_temps.pdf_classe', compact('classe', 'emplois'));
        return $pdf->stream('emploi-du-temps-classe-' . $classe->nom . '.pdf');
    }

    // PDF pour un maitre
    public function printMaitre($id)
    {
        $maitre = Maitre::findOrFail($id);
        $emplois = EmploisDuTemps::with(['classe', 'matiere'])
            ->where('maitre_id', $id)
            ->get();

        $pdf = Pdf::loadView('admin.emplois_du_temps.pdf_maitre', compact('maitre', 'emplois'));
        return $pdf->stream('emploi-du-temps-maitre-' . $maitre->nom . '.pdf');
    }
}
