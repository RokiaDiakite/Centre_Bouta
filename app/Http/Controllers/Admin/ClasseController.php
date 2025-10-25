<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

class ClasseController extends Controller
{
    public function index()
    {
        $classes = Classe::withCount('eleves')->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'niveau' => 'required|string|max:50',
            'frais' => 'nullable|numeric',
        ]);

        // Calculer le niveau_ordre automatiquement
        $dernierOrdre = Classe::max('niveau_ordre') ?? 0;

        Classe::create([
            'nom' => $request->nom,
            'niveau' => $request->niveau,
            'frais' => $request->frais ?? 0,
            'niveau_ordre' => $dernierOrdre + 1,
        ]);

        Toastr::success('Classe ajoutée', 'Succès');
        return redirect()->route('classe.index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'nom' => 'required|string|max:100',
            'niveau' => 'required|string|max:50',
            'frais' => 'nullable|numeric',
        ]);

        $classe = Classe::findOrFail($request->id);
        $classe->update([
            'nom' => $request->nom,
            'niveau' => $request->niveau,
            'frais' => $request->frais ?? 0,
            // On ne touche pas à niveau_ordre lors de la mise à jour
        ]);

        Toastr::success('Classe mise à jour', 'Succès');
        return redirect()->route('classe.index');
    }


    public function edit($id)
    {
        $classe = Classe::findOrFail($id);
        return view('admin.classes.edit', compact('classe'));
    }



    public function destroy(Request $request)
    {
        $classe = Classe::findOrFail($request->id);
        $classe->delete();
        Toastr::success('Classe supprimée', 'Succès');
        return back();
    }
}
