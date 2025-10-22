@extends('layouts.maitre')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Mes Paiements</h2>

    @if($paiements->isEmpty())
    <div class="alert alert-info text-center">
        Aucun paiement enregistré pour le moment.
    </div>
    @else
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Mois</th>
                <th>Montant</th>
                <th>Date Paiement</th>
                <th>Mode de Paiement</th>
                <th>Année Scolaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $paiement)
            <tr>
                <td>{{ ucfirst($paiement->mois) }}</td>
                <td>{{ number_format($paiement->montant, 2, ',', ' ') }} €</td>
                <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                <td>{{ $paiement->mode_paiement ?? '-' }}</td>
                <td>{{ $paiement->anneeScolaire->annee ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection