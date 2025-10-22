<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Maitre;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MaitreController extends Controller
{
    public function index()

    {

        $maitres = Maitre::all();

        return view('admin.maitres.index', compact('maitres'));
    }

    public function create()

    {

        return view('admin.maitres.create');
    }

    public function store(Request $request)

    {

        $request->validate([

            'nom' => 'required|string|max:100',

            'prenom' => 'required|string|max:100',

            'email' => 'nullable|email|unique:maitres,email',

            'password' => 'nullable|min:6',

            'numero' => 'nullable|string',

            'username' => 'nullable|string',

            'adresse' => 'nullable|string',

            'salaire' => 'nullable|numeric'

        ]);

        $data = $request->only('nom', 'prenom', 'email', 'numero', 'adresse', 'username', 'salaire');

        if ($request->filled('password')) {

            $data['password'] = Hash::make($request->password);
        }

        Maitre::create($data);

        Toastr::success('Maître ajouté', 'Succès');

        return redirect()->route('maitre.index');
    }

    public function edit($id)

    {

        $maitre = Maitre::findOrFail($id);

        return view('admin.maitres.edit', compact('maitre'));
    }

    public function update(Request $request)

    {

        $request->validate([

            'id' => 'required|integer',

            'nom' => 'required|string|max:100',

            'prenom' => 'required|string|max:100',

            'email' => 'nullable|email',

            'password' => 'nullable|min:6',

            'numero' => 'nullable|string',

            'adresse' => 'nullable|string',

            'username' => 'nullable|string',

            'salaire' => 'nullable|numeric'

        ]);

        $maitre = Maitre::findOrFail($request->id);

        $data = $request->only('nom', 'prenom', 'email', 'numero', 'adresse', 'salaire', 'username');

        if ($request->filled('password')) {

            $data['password'] = Hash::make($request->password);
        }

        $maitre->update($data);

        Toastr::success('Maître mis à jour', 'Succès');

        return redirect()->route('maitre.index');
    }
    

    public function destroy(Request $request)

    {

        $maitre = Maitre::findOrFail($request->id);

        $maitre->delete();

        Toastr::success('Maître supprimé', 'Succès');

        return back();
    }
    
}
