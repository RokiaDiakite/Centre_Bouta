@extends('layouts.maitre')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Détail du Paiement</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-primary mb-3">
                Paiement du mois de {{ ucfirst($paiement->mois) }}
            </h5>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong>Montant :</strong>
                    {{ number_format($paiement->montant, 2, ',', ' ') }} €
                </li>

                <li class="list-group-item">
                    <strong>Date du Paiement :</strong>
                    {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}
                </li>

                <li class="list-group-item">
                    <strong>Mode de Paiement :</strong>
                    {{ $paiement->mode_paiement ?? 'Non spécifié' }}
                </li>

                <li class="list-group-item">
                    <strong>Année Scolaire :</strong>
                    {{ $paiement->anneeScolaire->annee ?? 'Non spécifiée' }}
                </li>

                
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('maitre.paiement.index') }}" class="btn btn-secondary">
                ⬅️ Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection