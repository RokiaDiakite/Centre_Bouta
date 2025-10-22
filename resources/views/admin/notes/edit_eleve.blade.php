@extends('layouts.admin')
@section('title','Modifier Notes Élève')

@section('content')
<div class="container mt-4">

    <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">✏️ Modifier les Notes de {{ $eleve->nom }} {{ $eleve->prenom }}</h4>
        <a href="{{ route('note.index') }}" class="btn btn-warning btn-sm fw-bold px-3">
            ⬅️ Retour
        </a>
    </div>

    <form action="{{ route('note.update.eleve', [$eleve->id, $annee->id, $classe->id]) }}" method="POST">
        @csrf
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Matière</th>
                    <th>Devoir (CC)</th>
                    <th>Évaluation</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matieres as $matiere)
                <tr>
                    <td>{{ $matiere->nom }}</td>
                    <td><input type="number" step="0.01" name="notes[{{ $matiere->id }}][cc]" class="form-control"
                            value="{{ $notes[$matiere->id]->note_devoir ?? '' }}" min="0" max="20"></td>
                    <td><input type="number" step="0.01" name="notes[{{ $matiere->id }}][evaluation]" class="form-control"
                            value="{{ $notes[$matiere->id]->note_evaluation ?? '' }}" min="0" max="20"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button class="btn btn-success w-100 mt-3">💾 Enregistrer</button>
    </form>
</div>
@endsection