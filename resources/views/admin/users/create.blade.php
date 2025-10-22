@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Ajouter un utilisateur</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nom utilisateur</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('user.index') }}" class="btn btn-secondary">⬅ Retour</a>
            <button type="submit" class="btn btn-primary">💾 Créer l’utilisateur</button>
        </div>
    </form>
</div>
@endsection