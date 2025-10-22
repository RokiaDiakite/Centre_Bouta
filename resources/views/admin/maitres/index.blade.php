@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Maitre</h4>
            <a class="btn btn-primary" href="{{ route('maitre.create') }}">Ajouter</a>
    
    <div class="card">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Numéro</th>
                        <th>Adresse</th>
                        <th>Salaire</th>
                        <th>Non utilisateur</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($maitres as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td><strong>{{ $data->nom }}</strong></td>
                        <td><strong>{{ $data->prenom }}</strong></td>
                        <td><strong>{{ $data->email }}</strong></td>
                        <td><strong>{{ $data->numero }}</strong></td>
                        <td><strong>{{ $data->adresse }}</strong></td>
                        <td><strong>{{ $data->salaire }}</strong></td>
                        <td><strong>{{ $data->username }}</strong></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('maitre.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>

                                    <form action="{{ route('maitre.delete', $data->id) }}" method="POST" style="display:inline-block">
                                        @csrf
    
                                        <button type="submit" class="btn btn-danger dropdown-item"
                                            onclick="return confirm('Voulez-vous vraiment supprimer ce maitre ?')">
                                            <i class="bx bx-trash me-1"></i> Supprimer
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

        
    </div>
</div>
@endsection
