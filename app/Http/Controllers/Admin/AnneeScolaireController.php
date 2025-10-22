<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AnneeScolaire;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

class AnneeScolaireController extends Controller
{
    public function index()

    {

        $annees = AnneeScolaire::latest()->get();

        return view('admin.annee_scolaires.index', compact('annees'));

    }
 
    public function create()

    {

        return view('admin.annee_scolaires.create');

    }
 
    public function store(Request $request)

    {

        $request->validate([

            'libelle' => 'required|string|max:50',

            'statut'  => 'nullable|boolean',

        ]);
 
        AnneeScolaire::create([

            'libelle' => $request->libelle,

            'statut'  => $request->statut ? 1 : 0,

        ]);
 
        Toastr::success('Année scolaire créée avec succès', 'Succès');

        return redirect()->route('annee.index');

    }
 
    public function edit($id)

    {

        $annee = AnneeScolaire::findOrFail($id);

        return view('admin.annee_scolaires.edit', compact('annee'));

    }
 
    public function update(Request $request)

    {

        $request->validate([

            'id' => 'required|integer',

            'libelle' => 'required|string|max:50',

            'statut'  => 'nullable|boolean',

        ]);
 
        $annee = AnneeScolaire::findOrFail($request->id);

        $annee->update([

            'libelle' => $request->libelle,

            'statut'  => $request->statut ? 1 : 0,

        ]);
 
        Toastr::success('Année scolaire mise à jour', 'Succès');

        return redirect()->route('annee.index');

    }
 
    public function destroy(Request $request)

    {

        $annee = AnneeScolaire::findOrFail($request->id);

        $annee->delete();

        Toastr::success('Année scolaire supprimée', 'Succès');

        return redirect()->route('annee.index') ;

    }
 
}
