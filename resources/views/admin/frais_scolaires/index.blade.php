@extends('layouts.admin')

@section('content')
@php use Illuminate\Support\Str; @endphp

<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Gestion des Paiements Scolaires</h4>

    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Filtre par année scolaire --}}
        <div class="d-flex justify-content-between align-items-center px-3 mt-3">
            <h5 class="card-header">Liste des frais scolaires</h5>
            <form method="GET" action="{{ route('frais.index') }}" class="d-flex align-items-center">
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
                <a href="{{ route('frais.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                @endif
            </form>
        </div>

        <div class="d-flex justify-content-end px-3 gap-4">
            <a href="{{ route('frais.create') }}" class="btn btn-primary mb-3">Ajouter un frais</a>
            <a href="{{ route('frais.statistique-eleve') }}" class="btn btn-primary mb-3">
                Statistique / Élève
            </a>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Année scolaire</th>
                        <th>Montant total</th>
                        <th>Montant payé</th>
                        <th>Reliquat</th>
                        <th>Date</th>
                        <th>Mode</th>
                        <th>Justificatif</th>
                        <th>Reçu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($frais as $f)
                    <tr>
                        <td>{{ $f->eleve->nom ?? '' }} {{ $f->eleve->prenom ?? '' }}</td>
                        <td>{{ $f->classe->nom ?? '' }}</td>
                        <td>{{ $f->anneeScolaire->libelle ?? '' }}</td>
                        <td>{{ $f->montant_total }}</td>
                        <td>{{ $f->montant_paye }}</td>
                        <td>{{ $f->reliquat }}</td>
                        <td>{{ $f->date_paiement }}</td>
                        <td>{{ $f->mode_de_paiement }}</td>
                        <td>
                            @if($f->fichier_pdf)
                            @if(Str::endsWith($f->fichier_pdf, '.pdf'))
                            <a href="{{ asset('storage/'.$f->fichier_pdf) }}" target="_blank">📄 Voir PDF</a>
                            @else
                            <a href="{{ asset('storage/'.$f->fichier_pdf) }}" target="_blank">
                                <img src="{{ asset('storage/'.$f->fichier_pdf) }}" width="60" height="60" style="object-fit:cover; border-radius:5px;">
                            </a>
                            @endif
                            @else
                            <span class="text-muted">Aucun fichier</span>
                            @endif
                        </td>
                        <td>{{ $f->numero_recu }}</td>
                        <td>
                            <a href="{{ route('frais.edit', $f->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('frais.delete', $f->id) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted">Aucun frais scolaire trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection