@extends('layouts.tuteur')
@section('title', 'Bulletin Scolaire')
@section('content')
<div class="container mt-4">
    <div class="card p-3 shadow-sm mx-auto" style="max-width: 900px;">
        <h1 class="text-center mb-1">Complexe Scolaire Centre Bouta</h1>
        <h5 class="text-center mb-3">Bulletin Scolaire</h5>

        <div class="text-center small mb-2">
            <strong>Année scolaire :</strong> {{ $eleve->annee_scolaire->libelle ?? '-' }} |
            <strong>Évaluation :</strong> {{ $evaluation->nom ?? '-' }}
        </div>

        <div class="text-center small mb-3">
            <strong>Nom & prénom :</strong> {{ $eleve->nom }} {{ $eleve->prenom }} |
            <strong>Sexe :</strong> {{ $eleve->sexe ?? '-' }} |
            <strong>Classe :</strong> {{ $eleve->classe->nom ?? '-' }}
        </div>

        <div class="text-center mb-3 no-print">
            <a href="{{ route('tuteur.bulletin.index') }}" class="btn btn-sm btn-secondary">⬅ Retour</a><!-- 
            <a href="{{ route('tuteur.bulletin.download', $eleve->id) }}" class="btn btn-sm btn-primary">📄 Télécharger PDF</a> -->
        </div>

        @if($notes->isEmpty())
        <div class="alert alert-info text-center">Pas de bulletin encore disponible pour cet élève.</div>
        @else
        <table class="table table-bordered table-sm text-center">
            <thead class="table-light small">
                <tr>
                    <th>Matières</th>
                    <th>Devoir</th>
                    <th>Composition</th>
                    <th>Coefficient</th>
                    <th>Moyenne matière</th>
                    <th>Appréciation</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPondere = 0; $sommeCoef = 0; @endphp
                @foreach($matieres as $matiere)
                @php
                $note = $notes[$matiere->id] ?? null;
                $coef = $matiere->coefficient ?? 1;
                $devoir = floatval($note->note_devoir ?? 0);
                $evalNote = floatval($note->note_evaluation ?? 0);
                $moyenneMatiere = ($devoir + 2 * $evalNote)/3;
                $totalPondere += $moyenneMatiere * $coef;
                $sommeCoef += $coef;
                $appMatiere = $appreciationsMatiere[$matiere->id] ?? '-';
                @endphp
                <tr>
                    <td>{{ $matiere->nom }}</td>
                    <td>{{ $devoir ?: '-' }}</td>
                    <td>{{ $evalNote ?: '-' }}</td>
                    <td>{{ $coef }}</td>
                    <td>{{ number_format($moyenneMatiere,2) }}</td>
                    <td>{{ $appMatiere }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="small">
                @php $moyenneGenerale = $sommeCoef ? $totalPondere/$sommeCoef : 0; @endphp
                <tr>
                    <th colspan="5">Moyenne Générale</th>
                    <th>{{ number_format($moyenneGenerale,2) }}</th>
                </tr>
                <tr>
                    <th colspan="5">Appréciation</th>
                    <th>{{ $appreciation }}</th>
                </tr>
                <tr>
                    <th colspan="5">Rang</th>
                    <th>{{ $rang ?? '-' }}</th>
                </tr>
            </tfoot>
        </table>
        @endif

        <!-- Section signatures -->
        <div class="row mt-5">
            <div class="col text-center">
                <p>Le Directeur</p>
                <p>________________________</p>
            </div>
            <div class="col text-center">
                <p>Les Parents</p>
                <p>________________________</p>
            </div>
        </div>

        <!-- Proverbe / conseil -->
        <div class="text-center mt-4 mb-2 fst-italic text-primary">
            <p>{{ $proverbe }}</p>
        </div>
    </div>
</div>
@endsection