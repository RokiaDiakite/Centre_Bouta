@extends('layouts.tuteur')

@section('content')
<div class="container">
    <h3>Emploi du temps de {{ $eleve->nom }} {{ $eleve->prenom }}</h3>
    <a href="{{ route('tuteur.emplois.index') }}" class="btn btn-primary mb-3" >Retour</a>

    @php
    $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    // Récupère toutes les heures de début et fin uniques dans les emplois de l'élève
    $heures = $emplois->map(function($e){
    return $e->heure_debut . ' - ' . $e->heure_fin;
    })->unique()->sort();
    @endphp

    <table class="table table-bordered text-center">
        <thead class="table-secondary">
            <tr>
                <th>Heure / Jour</th>
                @foreach($jours as $jour)
                <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($heures as $heure)
            <tr>
                <td class="bg-gray-200 font-weight-bold">{{ $heure }}</td>
                @foreach($jours as $jour)
                @php
                [$debut, $fin] = explode(' - ', $heure);
                $emploiCell = $emplois->where('jour', $jour)
                ->where('heure_debut', $debut)
                ->where('heure_fin', $fin)
                ->first();
                @endphp
                <td>
                    @if($emploiCell)
                    <strong>{{ $emploiCell->matiere->nom }}</strong><br>
                    <small>{{ $emploiCell->maitre->nom }} {{ $emploiCell->maitre->prenom }}</small>
                    @else
                    -
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style>
    table th,
    table td {
        padding: 10px;
        vertical-align: middle;
    }

    table th {
        background-color: #d1d1d1;
        color: #000;
        font-weight: bold;
    }

    table td {
        font-size: 0.9rem;
    }

    td {
        min-width: 120px;
    }
</style>
@endsection