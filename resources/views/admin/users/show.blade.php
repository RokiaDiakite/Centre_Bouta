@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Détails de l’utilisateur</h4>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nom :</strong> {{ $user->nom }}</li>
        <li class="list-group-item"><strong>Prénom :</strong> {{ $user->prenom }}</li>
        <li class="list-group-item"><strong>Nom utilisateur :</strong> {{ $user->username }}</li>
        <li class="list-group-item"><strong>Email :</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Date de création :</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
    </ul>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('user.index') }}" class="btn btn-secondary">⬅ Retour</a>
        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">✏️ Modifier</a>
        <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">🗑 Supprimer</button>
        </form>
    </div>
</div>
@endsection