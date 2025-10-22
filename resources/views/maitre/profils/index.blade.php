@extends('layouts.maitre')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Mon Profil</h2>

    @if(session('success'))
    <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nom :</strong> {{ $maitre->nom }}</li>
                <li class="list-group-item"><strong>Prénom :</strong> {{ $maitre->prenom }}</li>
                <li class="list-group-item"><strong>Nom d'utilisateur :</strong> {{ $maitre->username }}</li>
                <li class="list-group-item"><strong>Email :</strong> {{ $maitre->email }}</li>
            </ul>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('maitre.profile.edit') }}" class="btn btn-primary">Modifier mon profil</a>
            <a class="btn btn-secondary float-end" href="{{route('maitre.dashboard')}}">Retour</a>
        </div>
    </div>
</div>
@endsection