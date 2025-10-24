@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Tables /</span> Élèves
    </h4>

    <div class="card mb-4">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center px-3 py-2">
            <h5 class="card-header mb-0">Liste des élèves</h5>
        </div>

        <!-- Filtre par classe et année scolaire -->
        <form method="GET" action="{{ route('eleve.index') }}" class="d-flex gap-3 px-3 py-3">
            <div>
                <label for="classe_id" class="form-label">Classe :</label>
                <select name="classe_id" id="classe_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes les classes</option>
                    @foreach($classes as $classe)
                    <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="annee_scolaire_id" class="form-label">Année scolaire :</label>
                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Toutes les années</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Sexe</th>
                        <th>Date naissance</th>
                        <th>Lieu naissance</th>
                        <th>Adresse</th>
                        <th>Nom père</th>
                        <th>Nom mère</th>
                        <th>Tuteur</th>
                        <th>Classe</th>
                        <th>Année scolaire</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eleves as $eleve)
                    <tr>
                        <td>{{ $eleve->id }}</td>
                        <td>{{ $eleve->matricule }}</td>
                        <td>{{ $eleve->nom }}</td>
                        <td>{{ $eleve->prenom }}</td>
                        <td>{{ $eleve->sexe }}</td>
                        <td>{{ $eleve->date_naissance }}</td>
                        <td>{{ $eleve->lieu_naissance }}</td>
                        <td>{{ $eleve->adresse }}</td>
                        <td>{{ $eleve->nom_pere }}</td>
                        <td>{{ $eleve->nom_mere }}</td>
                        <td>{{ $eleve->tuteur?->nom }} {{ $eleve->tuteur?->prenom }}</td>
                        <td>{{ $eleve->classe?->nom }}</td>
                        <td>{{ $eleve->derniereInscription?->anneeScolaire?->libelle ?? '—' }}</td>
                        <td>{{ ucfirst($eleve->statut) }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('eleve.edit', $eleve->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('eleve.delete', $eleve->id) }}" method="POST" onsubmit="return confirm('Supprimer cet élève ?')">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bx bx-trash me-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="15" class="text-center">Aucun élève trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection