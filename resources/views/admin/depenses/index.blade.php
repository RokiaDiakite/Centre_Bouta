@extends('layouts.admin')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Gestion des Dépenses</h4>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="d-flex justify-content-between align-items-center px-3 mt-3">
            <h5 class="card-header">Liste des Dépenses</h5>

            <form method="GET" action="{{ route('depense.index') }}" class="d-flex align-items-center">
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
                <a href="{{ route('depense.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                @endif
            </form>
        </div>

        <div class="d-flex justify-content-end px-3">
            <a href="{{ route('depense.create') }}" class="btn btn-primary mb-3">Ajouter une Dépense</a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Année scolaire</th>
                        <th>Intitulé</th>
                        <th>Montant</th>
                        <th>Justificatif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($depenses as $depense)
                    <tr>
                        <td>{{ $depense->date }}</td>
                        <td>{{ $depense->anneeScolaire->libelle ?? '-' }}</td>
                        <td>{{ $depense->intitule }}</td>
                        <td>{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                        <td>
                            @if($depense->fichier_pdf)
                                @if(Str::endsWith($depense->fichier_pdf, '.pdf'))
                                    <a href="{{ asset('storage/'.$depense->fichier_pdf) }}" target="_blank">📄 Voir PDF</a>
                                @else
                                    <a href="{{ asset('storage/'.$depense->fichier_pdf) }}" target="_blank">
                                        <img src="{{ asset('storage/'.$depense->fichier_pdf) }}" width="60" height="60" style="object-fit:cover; border-radius:5px;">
                                    </a>
                                @endif
                            @else
                                <span class="text-muted">Aucun fichier</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('depense.edit', $depense->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('depense.delete', $depense->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette dépense ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucune dépense trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
