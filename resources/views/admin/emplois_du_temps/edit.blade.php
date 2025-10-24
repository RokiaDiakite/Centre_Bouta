@extends('layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Modifier un créneau</h3>
    <a href="{{ route('emploi.index') }}" class="btn btn-primary mb-3">Retour</a>
    <form action="{{ route('emploi.update', $edt->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Année scolaire</label>
            <select name="annee_scolaire_id" class="form-select" required>
            <option value="">--Choisissez une année scolaire--</option>
                @foreach($annees as $annee)
                <option value="{{ $annee->id }}" {{ $edt->annee_scolaire_id == $annee->id ? 'selected' : '' }}>
                    {{ $annee->libelle }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Classe</label>
            <select name="classe_id" class="form-select" required>
             <option value="">--Choisissez la classe--</option>
                @foreach($classes as $classe)
                <option value="{{ $classe->id }}" {{ $edt->classe_id == $classe->id ? 'selected' : '' }}>
                    {{ $classe->nom }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Matière</label>
            <select name="matiere_id" class="form-select" required>
            <option value="">--Choisissez la matière--</option>
                @foreach($matieres as $matiere)
                <option value="{{ $matiere->id }}" {{ $edt->matiere_id == $matiere->id ? 'selected' : '' }}>
                    {{ $matiere->nom }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Maitre</label>
            <select name="maitre_id" class="form-select" required>
             <option value="">--Choisissez le maitre--</option>
                @foreach($maitres as $maitre)
                <option value="{{ $maitre->id }}" {{ $edt->maitre_id == $maitre->id ? 'selected' : '' }}>
                    {{ $maitre->nom }} {{ $maitre->prenom }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Jour</label>
            <select name="jour" class="form-control" required>
            <option value="">--Choisissez le jour--</option>
                @foreach(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'] as $jour)
                <option value="{{ $jour }}" {{ $edt->jour == $jour ? 'selected' : '' }}>
                    {{ $jour }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Heure début</label>
            <input type="time" name="heure_debut" value="{{ $edt->heure_debut }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Heure fin</label>
            <input type="time" name="heure_fin" value="{{ $edt->heure_fin }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">💾 Mettre à jour</button>
    </form>
</div>
@endsection