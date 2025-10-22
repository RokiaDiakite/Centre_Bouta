@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Gestion des Paiements des Maîtres</h4>

    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filtre par année scolaire --}}
        <div class="d-flex justify-content-between align-items-center px-3 mt-3">
            <h5 class="card-header">Liste des paiements</h5>
            <form method="GET" action="{{ route('paiement-maitre.index') }}" class="d-flex align-items-center">
                <label for="annee_scolaire_id" class="me-2 mb-0">Année scolaire :</label>
                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select me-2" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach($annees as $a)
                    <option value="{{ $a->id }}" {{ $anneeId == $a->id ? 'selected' : '' }}>
                        {{ $a->libelle }}
                    </option>
                    @endforeach
                </select>
                @if($anneeId)
                <a href="{{ route('paiement-maitre.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                @endif
            </form>
        </div>

        <div class="d-flex justify-content-end px-3">
            <a href="{{ route('paiement-maitre.create') }}" class="btn btn-primary mb-3">Ajouter un paiement</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Maître</th>
                        <th>Année scolaire</th>
                        <th>Mois</th>
                        <th>Montant</th>
                        <th>Date</th>
                        <th>Mode de paiement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paiements as $p)
                    <tr>
                        <td>{{ $p->maitre->nom ?? '' }} {{ $p->maitre->prenom ?? '' }}</td>
                        <td>{{ $p->anneeScolaire->libelle ?? '' }}</td>
                        <td>{{ $p->mois }}</td>
                        <td>{{ number_format($p->montant, 0, ',', ' ') }} FCFA</td>
                        <td>{{ $p->date_paiement }}</td>
                        <td>{{ $p->mode_paiement }}</td>
                        <td>
                            <a href="{{ route('paiement-maitre.edit', $p->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('paiement-maitre.delete', $p->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce paiement ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Aucun paiement trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection