@extends('layouts.maitre')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Modifier mon Profil</h2>

    <form action="{{ route('maitre.profile.update') }}" method="POST" class="card shadow-sm p-4">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $maitre->nom) }}" required>
            @error('nom') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" value="{{ old('prenom', $maitre->prenom) }}" required>
            @error('prenom') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $maitre->username) }}" required>
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $maitre->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe (facultatif)</label>
            <input type="password" name="password" id="password" class="form-control">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>

        <div class="text-end">
            <a href="{{ route('maitre.profile.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </div>
    </form>
</div>
@endsection