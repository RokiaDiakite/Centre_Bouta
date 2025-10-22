@extends('layouts.admin')
@section('content')
<h3>Ajouter un créneau</h3>
<a href="{{ route('emploi.index') }}" class="btn btn-warning mb-3">Retour</a>

<form action="{{ route('emploi.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Année scolaire</label>
        <select name="annee_scolaire_id" class="form-control" required>
            @foreach($annees as $annee)
            <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Classe</label>
        <select name="classe_id" class="form-control" required>
            @foreach($classes as $classe)
            <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Matière</label>
        <select name="matiere_id" class="form-control" required>
            @foreach($matieres as $matiere)
            <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Maitre</label>
        <select name="maitre_id" class="form-control" required>
            @foreach($maitres as $maitre)
            <option value="{{ $maitre->id }}">{{ $maitre->nom }} {{ $maitre->prenom }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Jour</label>
        <select name="jour" class="form-control" required>
            @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
            <option value="{{ $jour }}">{{ $jour }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Heure début</label>
        <input type="time" name="heure_debut" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Heure fin</label>
        <input type="time" name="heure_fin" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Ajouter</button>
</form>
@endsection