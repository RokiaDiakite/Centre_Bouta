@extends('layouts.admin')
@section('title','Ajouter des Notes - Élève')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">➕ Ajouter une note pour un élève</h4>
            <a href="{{ route('note.index') }}" class="btn btn-warning btn-sm fw-bold px-3">⬅️ Retour</a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('note.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Année scolaire</label>
                        <select name="annee_id" id="annee_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($annees as $a)
                            <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Classe</label>
                        <select name="classe_id" id="classe_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Élève</label>
                        <select name="eleve_id" id="eleve_id" class="form-select" required>
                            <option value="">-- Sélectionner une classe d'abord --</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Matière</label>
                        <select name="matiere_id" id="matiere_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($matieres as $m)
                            <option value="{{ $m->id }}" data-coefficient="{{ $m->coefficient }}">{{ $m->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Évaluation</label>
                        <select name="evaluation_id" id="evaluation_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($evaluations as $e)
                            <option value="{{ $e->id }}">{{ $e->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Note de devoir</label>
                        <input type="number" name="note_devoir" step="0.01" class="form-control" min="0" max="20" placeholder="Ex: 15,75">
                    </div>
                    <div class="col-md-3">
                        <label>Note d’évaluation</label>
                        <input type="number" name="note_evaluation" step="0.01" class="form-control" min="0" max="20" placeholder="Ex: 14,50">
                    </div>
                </div>

                <button class="btn btn-success mt-3">💾 Enregistrer</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classeSelect = document.getElementById('classe_id');
        const eleveSelect = document.getElementById('eleve_id');

        // Charger les élèves selon la classe
        classeSelect.addEventListener('change', function() {
            const classeId = this.value;
            eleveSelect.innerHTML = '<option>Chargement...</option>';

            if (classeId) {
                fetch(`/admin/notes/eleves/${classeId}`)
                    .then(res => res.json())
                    .then(data => {
                        eleveSelect.innerHTML = '<option value="">-- Sélectionner --</option>';
                        data.forEach(eleve => {
                            eleveSelect.innerHTML += `<option value="${eleve.id}">${eleve.nom} ${eleve.prenom}</option>`;
                        });
                    })
                    .catch(err => {
                        eleveSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                        console.error(err);
                    });
            }
        });
    });
</script>
@endsection