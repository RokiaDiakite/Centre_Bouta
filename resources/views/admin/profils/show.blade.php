@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>✏️ Modifier mon profil</h4>

        <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">
            ⬅️ Retour au profil
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card p-4 mt-3">
        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $user->nom) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="username" class="form-label">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Adresse e-mail</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe (optionnel)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>
@endsection