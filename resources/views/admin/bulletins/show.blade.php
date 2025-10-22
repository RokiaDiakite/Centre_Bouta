@extends('layouts.admin')
@section('title', 'Bulletin Scolaire')
@section('content')
<div class="container mt-4">
    <div class="card p-3 shadow-sm mx-auto" style="max-width: 900px;">
        <h1 class="text-center mb-1">Complexe Scolaire Centre Bouta</h1>
        <h5 class="text-center mb-3">Bulletin Scolaire</h5>

        <div class="text-center small mb-2">
            <strong>Année scolaire :</strong> {{ $annee->libelle }} |
            <strong>Évaluation :</strong> {{ $evaluation->nom }}
        </div>

        <div class="text-center small mb-3">
            <strong>Nom & prénom :</strong> {{ $eleve->nom }} {{ $eleve->prenom }} |
            <strong>Sexe :</strong> {{ $eleve->sexe }} |
            <strong>Classe :</strong> {{ $classe->nom }}
        </div>

        <div class="text-center mb-3 no-print">
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">⬅ Retour</a>
            <button onclick="window.print()" class="btn btn-sm btn-primary">🖨 Imprimer</button>
        </div>

        <table class="table table-bordered table-sm text-center">
            <thead class="table-light small">
                <tr>
                    <th>Matières</th>
                    <th>Dévoir</th>
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
                    <th colspan="5">Moyenne Max Classe</th>
                    <th>{{ number_format($moyenneMax,2) }}</th>
                </tr>
                <tr>
                    <th colspan="5">Moyenne Min Classe</th>
                    <th>{{ number_format($moyenneMin,2) }}</th>
                </tr>
                <tr>
                    <th colspan="5">Appréciation</th>
                    <th>{{ $appreciation }}</th>
                </tr>
            </tfoot>
        </table>

        <p class="small mt-2"><strong>Rang :</strong> {{ $rang }} / {{ $effectifClasse }}</p>

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