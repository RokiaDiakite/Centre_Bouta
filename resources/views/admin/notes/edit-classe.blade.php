@extends('layouts.admin')
@section('title','Modifier Notes Classe')

@section('content')
<div class="container mt-4">

    <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">✏️ Modifier les Notes - {{ $classe->nom }} ({{ $annee->libelle }})</h4>
        <a href="{{ route('note.index') }}" class="btn btn-warning btn-sm fw-bold px-3">
            ⬅️ Retour
        </a>
    </div>

    <form action="{{ route('note.update.classe', [$classe->id, $annee->id]) }}" method="POST">
        @csrf

        @foreach($eleves as $eleve)
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-light fw-bold">{{ $eleve->nom }} {{ $eleve->prenom }}</div>
            <div class="card-body row g-3">
                @foreach($matieres as $matiere)
                @php
                // Récupère la note existante pour cet élève et cette matière
                $note = $eleve->notes->firstWhere('matiere_id', $matiere->id);
                $note_devoir = old('notes.' . $eleve->id . '.' . $matiere->id . '.cc', $note->note_devoir ?? '');
                $note_evaluation = old('notes.' . $eleve->id . '.' . $matiere->id . '.evaluation', $note->note_evaluation ?? '');
                @endphp
                <div class="col-md-4">
                    <label class="fw-semibold">{{ $matiere->nom }}</label>
                    <input type="number" step="0.01" min="0" max="20" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][cc]"
                        class="form-control mb-1" value="{{ $note_devoir }}" placeholder="Devoir">
                    <input type="number" step="0.01" min="0" max="20" name="notes[{{ $eleve->id }}][{{ $matiere->id }}][evaluation]"
                        class="form-control" value="{{ $note_evaluation }}" placeholder="Évaluation">
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="text-center">
            <button class="btn btn-primary w-50 mt-3">💾 Enregistrer les modifications</button>
        </div>
    </form>
</div>
@endsection