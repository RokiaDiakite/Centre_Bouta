<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

class MatiereController extends Controller
{
    public function index(Request $request)
    {
        $query = Matiere::with('classes'); // Charger les relations classes

        // 🔹 Filtre par nom
        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }

        // 🔹 Filtre par classe
        if ($request->filled('classe_id')) {
            $query->whereHas('classes', function ($q) use ($request) {
                $q->where('classes.id', $request->classe_id);
            });
        }

        $matieres = $query->paginate(15)->withQueryString();
        $classes = Classe::all(); // pour le select de filtrage

        return view('admin.matieres.index', compact('matieres', 'classes'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('admin.matieres.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'     => 'required|string|max:255',
            'coefficient'    => 'required|numeric',
            'classes' => 'required|array|min:1', // au moins une classe
            'classes.*' => 'exists:classes,id',
        ]);

        // Création de la matière
        $matiere = Matiere::create([
            'nom'  => $request->nom,
            'coefficient' => $request->coefficient,
        ]);

        // Liaison avec les classes sélectionnées
        $matiere->classes()->attach($request->classes);

        return redirect()->route('matiere.index')
            ->with('success', 'Matière créée avec succès.');
    }


    public function edit($id)
    {
        $matiere = Matiere::with('classes')->findOrFail($id);
        $classes = Classe::all();
        return view('admin.matieres.edit', compact('matiere', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $matiere = Matiere::findOrFail($id);

        $request->validate([
            'nom'     => 'required|string|max:255',
            'coefficient'    => 'required|numeric',
            'classes' => 'required|array',
        ]);

        $matiere->update([
            'nom'  => $request->nom,
            'coefficient' => $request->coefficient,
        ]);

        // 🔹 Synchroniser les classes
        $matiere->classes()->sync($request->classes);

        return redirect()->route('matiere.index')
            ->with('success', 'Matière mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $matiere = Matiere::findOrFail($id);

        // 🔹 Détacher les classes avant suppression
        $matiere->classes()->detach();

        $matiere->delete();

        return redirect()->route('matiere.index')
            ->with('success', 'Matière supprimée avec succès.');
    }
}
