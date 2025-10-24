@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Détails du tuteur</h4>

    <ul class="list-group">
        <li class="list-group-item"><strong>Nom :</strong> {{ $tuteur->nom }}</li>
        <li class="list-group-item"><strong>Prénom :</strong> {{ $tuteur->prenom }}</li>
        <li class="list-group-item"><strong>Email :</strong> {{ $tuteur->email }}</li>
        <li class="list-group-item"><strong>Adresse :</strong> {{ $tuteur->adresse ?? '—' }}</li>
        <li class="list-group-item"><strong>Numero :</strong> {{ $tuteur->numero ?? '—' }}</li>
        <li class="list-group-item"><strong>Profession :</strong> {{ $tuteur->profession ?? '—' }}</li>
        <div class="mt-3 d-flex gap-2">
        <a href="{{ route('tuteur.index') }}" class="btn btn-secondary">Retour</a>
        <a href="{{ route('tuteur.edit', $tuteur->id) }}" class="btn btn-warning">Modifier</a>
        <form action="{{ route('tuteur.delete', $tuteur->id) }}" method="POST" 
              onsubmit="return confirm('Voulez-vous vraiment supprimer cet cet tuteur ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>
@endsection
