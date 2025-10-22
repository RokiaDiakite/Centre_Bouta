@extends('layouts.admin')
@section('content')
<div class="container">
    <h3>Emploi du temps - Classe {{ $classe->nom }}</h3>
    <a href="{{ route('emploi.select.classe') }}" class="btn btn-warning mb-3">Retour</a>

    @php
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $heures = $emplois->pluck('heure_debut')->sort()->unique();
    @endphp

    <table class="table table-bordered text-center">
        <thead style="background-color: #b0c4de; color: #000;">
            <tr>
                <th>Heures</th>
                @foreach($jours as $jour)
                    <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($heures as $heure)
            <tr>
                <td>{{ $heure }}</td>
                @foreach($jours as $jour)
                    @php
                        $cours = $emplois->first(function($e) use ($jour, $heure) {
                            return $e->jour == $jour && $e->heure_debut == $heure;
                        });
                    @endphp
                    <td>
                        @if($cours)
                            <strong>{{ $cours->matiere->nom }}</strong><br>
                            {{ $cours->maitre->nom }} {{ $cours->maitre->prenom }}
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
@endsection
