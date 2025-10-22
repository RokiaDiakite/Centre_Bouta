<?php

namespace App\Http\Controllers\Admin;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function index()

    {

        $evaluations = Evaluation::all();

        return view('admin.evaluations.index', compact('evaluations'));

    }
 
    public function create()

    {

        return view('admin.evaluations.create');

    }
 
    public function store(Request $request)

    {

        $request->validate(['nom'=>'required|string|max:100']);

        Evaluation::create(['nom'=>$request->nom]);

        Toastr::success('Évaluation ajoutée', 'Succès');

        return redirect()->route('evaluation.index');

    }
 
    public function edit($id)

    {

        $evaluation = Evaluation::findOrFail($id);

        return view('admin.evaluations.edit', compact('evaluation'));

    }
 
    public function update(Request $request)

    {

        $request->validate(['id'=>'required','nom'=>'required|string|max:100']);

        $evaluation = Evaluation::findOrFail($request->id);

        $evaluation->update(['nom'=>$request->nom]);

        Toastr::success('Évaluation mise à jour', 'Succès');

        return redirect()->route('evaluation.index');

    }
 
    public function destroy(Request $request)

    {

        $evaluation = Evaluation::findOrFail($request->id);

        $evaluation->delete();

        Toastr::success('Évaluation supprimée', 'Succès');

        return back();

    }
 
}
