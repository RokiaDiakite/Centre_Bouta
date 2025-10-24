@extends('layouts.admin')
@section('title','Liste des Inscriptions')

@section('content')
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
            <div >
            <a class="btn btn-primary m-4" href="{{ route('inscription.create') }}">Ajouter</a>
            </div>
        </div>

        <div class="d-flex justify-content-end align-items-center mb-3 gap-3 p-3">
            <form method="GET" action="{{ route('inscription.index') }}" class="d-flex gap-3">
                <div>
                    <label for="classe_id" class="form-label mb-0"><strong>Classe:</strong></label>
                    <select id="classe_id" name="classe_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes</option>
                        @foreach ($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe_id') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="annee_scolaire_id" class="form-label mb-0"><strong>Année scolaire:</strong></label>
                    <select id="annee_scolaire_id" name="annee_scolaire_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Toutes</option>
                        @foreach ($annees as $annee)
                        <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                            {{ $annee->libelle }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Matricule</th>
                        <th>Élève</th>
                        <th>Classe</th>
                        <th>Année Scolaire</th>
                        <th>Date Inscription</th>
                        <th>Frais</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscriptions as $ins)
                    <tr>
                        <td>{{ $ins->id }}</td>
                        <td>{{ $ins->eleve->matricule }}</td>
                        <td>{{ $ins->eleve->nom }} {{ $ins->eleve->prenom }}</td>
                        <td>{{ $ins->classe->nom }}</td>
                        <td>{{ $ins->anneeScolaire->libelle }}</td>
                        <td>{{ $ins->date_inscrip }}</td>
                        <td>{{ number_format($ins->frais_ins,0,',',' ') }} FCFA</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>    
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('inscription.edit',$ins->id) }}">Modifier</a></li>
                                    <li>
                                        <form action="{{ route('inscription.delete',$ins->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Voulez-vous supprimer ?')" class="dropdown-item text-danger">Supprimer</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Aucune inscription trouvée</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection