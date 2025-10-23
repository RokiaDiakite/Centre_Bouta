@extends('layouts.tuteur')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Mon Profil</h2>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nom :</strong> {{ $tuteur->nom }}</li>
                <li class="list-group-item"><strong>Prénom :</strong> {{ $tuteur->prenom }}</li>
                <li class="list-group-item"><strong>Nom d'utilisateur :</strong> {{ $tuteur->username }}</li>
                <li class="list-group-item"><strong>Email :</strong> {{ $tuteur->email }}</li>
                <li class="list-group-item"><strong>Numéro :</strong> {{ $tuteur->numero }}</li>
                <li class="list-group-item"><strong>Profession :</strong> {{ $tuteur->profession }}</li>
                <li class="list-group-item"><strong>Adresse :</strong> {{ $tuteur->adresse }}</li>
            </ul>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('tuteur.profile.edit') }}" class="btn btn-primary">Modifier mon profil</a>
            <a class="btn btn-secondary float-end" href="{{ route('tuteur.dashboard') }}">Retour</a>
        </div>
    </div>
</div>
@endsection