@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span>Matières</h4>

    <div class="card">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center p-3">
            <h5 class="card-header">Liste des matières</h5>
            <a class="btn btn-primary" href="{{ route('matiere.create') }}">Ajouter</a>
        </div>

        <!-- 🔹 Formulaire de filtrage par classe -->
        <div class="p-3">
            <form method="GET" action="{{ route('matiere.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control"
                           placeholder="Rechercher une matière..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="classe_id" class="form-select">
                        <option value="">-- Filtrer par classe --</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                                {{ $classe->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Filtrer</button>
                    <a href="{{ route('matiere.index') }}" class="btn btn-outline-dark">Réinitialiser</a>
                </div>
            </form>
        </div>
        <!-- /Formulaire de filtrage -->

        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Coefficient</th>
                        <th>Classes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($matieres as $matiere)
                    <tr>
                        <td>{{ $matiere->id }}</td>
                        <td><strong>{{ $matiere->nom }}</strong></td>
                        <td><strong>{{ $matiere->coefficient }}</strong></td>
                        <td>
                            @foreach($matiere->classes as $classe)
                                <span class="badge bg-info text-dark">{{ $classe->nom }}</span>
                            @endforeach
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('matiere.edit', $matiere->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('matiere.delete', $matiere->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ?')" class="btn btn-danger btn-sm">
                                            <i class="bx bx-trash me-1"></i>Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-3">
            {{ $matieres->links() }}
        </div>
    </div>
</div>
@endsection
