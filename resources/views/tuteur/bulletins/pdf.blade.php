@extends('layouts.pdf') <!-- layout léger pour PDF -->
@section('content')
<h2 style="text-align:center;">Bulletin Scolaire - {{ $eleve->nom }} {{ $eleve->prenom }}</h2>

<table border="1" width="100%" cellpadding="5">
    <thead>
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
        @foreach($matieres as $matiere)
        @php
        $note = $notes[$matiere->id] ?? null;
        $coef = $matiere->coefficient ?? 1;
        $devoir = floatval($note->note_devoir ?? 0);
        $evalNote = floatval($note->note_evaluation ?? 0);
        $moyenneMatiere = ($devoir + 2 * $evalNote)/3;
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
</table>

<p>Moyenne Générale : {{ number_format($moyenneGenerale,2) }}</p>
<p>Appréciation : {{ $appreciation }}</p>
@endsection