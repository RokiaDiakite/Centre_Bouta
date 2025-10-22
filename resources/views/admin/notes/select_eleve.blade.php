@extends('layouts.admin')
@section('title','Sélectionner un Élève')

@section('content')
<div class="container mt-4">
    <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">✏️ Sélectionner un élève à modifier</h2>
        <a href="{{ route('note.index') }}" class="btn btn-warning btn-sm fw-bold px-3">
            ⬅️ Retour
        </a>
    </div>
    <form action="{{ route('note.edit.classe') }}" method="GET" class="card p-4 shadow-sm">
        <div class="row g-3">
            <div class="col-md-6">
                <label>Année scolaire</label>
                <select name="annee_id" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($annees as $a)
                    <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label>Classe</label>
                <select name="classe_id" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}">{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Élève</label>
                <select name="eleve_id" class="form-control" required>
                    <option value="">-- Sélectionner --</option>
                    @foreach($eleves as $e)
                    <option value="{{ $e->id }}">{{ $e->nom }} {{ $e->prenom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn btn-primary w-100 mt-3">➡️ Continuer</button>
    </form>

</div>
@endsection