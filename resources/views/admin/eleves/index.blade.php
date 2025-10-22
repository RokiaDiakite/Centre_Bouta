@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Élèves</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center px-3 py-2">
            <h5 class="card-header mb-0">Liste des élèves</h5>
            <!--  <a class="btn btn-primary" href="{{ route('eleve.create') }}">Ajouter un élève</a> -->
        </div>
        <form method="GET" action="{{ route('eleve.index') }}" class="mb-3 d-flex gap-2">
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


        <script>
            // ✅ Soumission automatique dès qu'on change une valeur
            document.querySelectorAll('#filterForm select').forEach(select => {
                select.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            });
        </script>


        <script>
            // ✅ Soumission automatique au changement
            document.getElementById('classe_id').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });

            document.getElementById('annee_scolaire_id').addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        </script>

        <!--  -->
        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Lieu de naissance</th>
                        <th>Sexe</th>
                        <th>Adresse</th>
                        <th>Nom père</th>
                        <th>Nom mère</th>
                        <th>Statut</th>
                        <th>Tuteur</th>
                        <th>Classe</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eleves as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td><strong>{{ $data->matricule }}</strong></td>
                        <td><strong>{{ $data->nom }}</strong></td>
                        <td><strong>{{ $data->prenom }}</strong></td>
                        <td>{{ $data->date_naissance }}</td>
                        <td>{{ $data->lieu_naissance }}</td>
                        <td>{{ $data->sexe }}</td>
                        <td>{{ $data->adresse }}</td>
                        <td>{{ $data->nom_pere }}</td>
                        <td>{{ $data->nom_mere }}</td>
                        <td>{{ $data->statut }}</td>
                        <td>
                            {{ $data->tuteur ? $data->tuteur->nom.' '.$data->tuteur->prenom : 'N/A' }}
                        </td>
                        <td>
                            {{ $data->classe ? $data->classe->nom : 'N/A' }}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('eleve.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('eleve.delete', $data->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ?')" class="btn btn-danger btn-sm">
                                            <i class="bx bx-trash me-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Aucun élève trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!--/ Basic Bootstrap Table -->
</div>
@endsection