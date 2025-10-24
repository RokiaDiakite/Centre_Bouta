@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Tables /</span> Tuteurs</h4>
        <a href="{{ route('tuteur.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajouter un tuteur
        </a>
    </div>

    <div class="card">
        @if(session('success'))
        <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger m-3">{{ session('error') }}</div>
        @endif

        <h5 class="card-header">Liste des tuteurs</h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro</th>
                        <th>Adresse</th>
                        <th>Profession</th>
                        <th>Email</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tuteurs as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->nom }}</td>
                        <td>{{ $data->prenom }}</td>
                        <td>{{ $data->numero }}</td>
                        <td>{{ $data->adresse }}</td>
                        <td>{{ $data->profession }}</td>
                        <td>{{ $data->email }}</td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('tuteur.show', $data->id) }}">
                                        <i class="bx bx-eye me-1" ></i>
                                        Voir
                                    </a>
                                    <a class="dropdown-item" href="{{ route('tuteur.edit', $data->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <!-- <form action="{{ route('tuteur.delete', $data->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer ce tuteur ?')">
                                            <i class="bx bx-trash me-1"></i> Supprimer
                                        </button>
                                    </form> -->
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">Aucun tuteur enregistré</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection