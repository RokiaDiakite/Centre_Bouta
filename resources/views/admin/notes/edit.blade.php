@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>✏️ Modifier la note</h2>

    <form action="{{ route('note.update', $note->id) }}" method="POST" class="card p-4 shadow-sm mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Année scolaire</label>
            <select name="annee_id" class="form-control" required>
                @foreach($annees as $annee)
                <option value="{{ $annee->id }}" {{ $note->annee_scolaire_id == $annee->id ? 'selected' : '' }}>
                    {{ $annee->libelle }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Classe</label>
            <select name="classe_id" class="form-control" required>
                @foreach($classes as $classe)
                <option value="{{ $classe->id }}" {{ $note->classe_id == $classe->id ? 'selected' : '' }}>
                    {{ $classe->nom }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Matière</label>
            <select name="matiere_id" class="form-control" required>
                @foreach($matieres as $matiere)
                <option value="{{ $matiere->id }}" {{ $note->matiere_id == $matiere->id ? 'selected' : '' }}>
                    {{ $matiere->nom }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Évaluation</label>
            <select name="evaluation_id" class="form-control" required>
                @foreach($evaluations as $evaluation)
                <option value="{{ $evaluation->id }}" {{ $note->evaluation_id == $evaluation->id ? 'selected' : '' }}>
                    {{ $evaluation->nom }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Note devoir</label>
            <input type="number" name="note_devoir" step="0.01" class="form-control"
                value="{{ old('note_devoir', $note->note_devoir) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Note évaluation</label>
            <input type="number" name="note_evaluation" step="0.01" class="form-control"
                value="{{ old('note_evaluation', $note->note_evaluation) }}">
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
            <a href="{{ route('note.index') }}" class="btn btn-secondary">↩ Retour</a>
        </div>
    </form>
</div>
@endsection