@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Tables /</span> Inscriptions
    </h4>

    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Liste des inscriptions</h5>
            <a class="btn btn-primary" href="{{ route('inscription.create') }}">Ajouter</a>
        </div>

        <div class="d-flex justify-content-end align-items-center mb-3 gap-3">
            <form method="GET" action="{{ route('inscription.index') }}" class="d-flex align-items-center gap-3">
                <!-- Filtre Classe -->
                <label for="classe_id" class="form-label mb-0"><strong>Classe:</strong></label>
                <select id="classe_id" name="classe_id" class="form-select" style="min-width: 180px; font-size: 1rem;" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach ($classes as $classe)
                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                    @endforeach
                </select>

                <!-- Filtre Année Scolaire -->
                <label for="annee_scolaire_id" class="form-label mb-0"><strong>Année scolaire:</strong></label>
                <select id="annee_scolaire_id" name="annee_scolaire_id" class="form-select" style="min-width: 150px; font-size: 1rem;" onchange="this.form.submit()">
                    <option value="">Toutes</option>
                    @foreach ($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>


        <!-- Tableau -->
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Année Scolaire</th>
                        <th>Date Inscription</th>
                        <th>Frais d’inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscriptions as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td><strong>{{ $data->eleve->nom }} {{ $data->eleve->prenom }}</strong></td>
                        <td>{{ $data->classe->nom }}</td>
                        <td>{{ $data->anneeScolaire->libelle }}</td>
                        <td>{{ $data->date_inscrip }}</td>
                        <td>{{ number_format($data->frais_ins, 0, ',', ' ') }} FCFA</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('inscription.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('inscription.delete', $data->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ?')" class="dropdown-item text-danger">
                                            <i class="bx bx-trash me-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucune inscription trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection