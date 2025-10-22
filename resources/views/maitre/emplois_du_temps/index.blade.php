@extends('layouts.maitre')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Mon Emploi du Temps</h2>

    @if($emplois->isEmpty())
    <div class="alert alert-info text-center">
        Aucun horaire trouvé pour le moment.
    </div>
    @else
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Jour</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Année Scolaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emplois as $emploi)
            <tr>
                <td>{{ ucfirst($emploi->jour) }}</td>
                <td>{{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}</td>
                <td>{{ $emploi->classe->nom }}</td>
                <td>{{ $emploi->matiere->nom }}</td>
                <td>{{ $emploi->anneeScolaire->annee ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="{{ route('maitre.emploi.print') }}" class="btn btn-primary">
            <i class="bi bi-printer"></i> Télécharger en PDF
        </a>
    </div>
    @endif
</div>
@endsection