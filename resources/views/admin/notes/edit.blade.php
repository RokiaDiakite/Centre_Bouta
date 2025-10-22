@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">✏️ Modifier la Note</h4>
        <a href="{{ route('note.index') }}" class="btn btn-warning btn-sm fw-bold px-3">
            ⬅️ Retour
        </a>
    </div>

    <a href="{{ route('note.index') }}" class="btn btn-secondary mb-3">⬅️ Retour</a>

    <form action="{{ route('note.update', $note->id) }}" method="POST" class="card p-4 shadow-sm">
        @csrf @method('PUT')

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label>Élève</label>
                <input type="text" class="form-control" value="{{ $note->eleve->nom }} {{ $note->eleve->prenom }}" readonly>
            </div>
            <div class="col-md-4">
                <label>Matière</label>
                <input type="text" class="form-control" value="{{ $note->matiere->nom }}" readonly>
            </div>
            <div class="col-md-2">
                <label>Devoir</label>
                <input type="text" name="note_devoir" class="form-control" value="{{ $note->note_devoir }}">
            </div>
            <div class="col-md-2">
                <label>Évaluation</label>
                <input type="text" name="note_evaluation" class="form-control" value="{{ $note->note_evaluation }}">
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-success px-4">💾 Enregistrer</button>
        </div>
    </form>
</div>
@endsection