@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Détails de l’élève</h4>

    <ul class="list-group">
        <li class="list-group-item"><strong>Matricule :</strong> {{ $eleve->matricule }}</li>
        <li class="list-group-item"><strong>Nom :</strong> {{ $eleve->nom }}</li>
        <li class="list-group-item"><strong>Prénom :</strong> {{ $eleve->prenom }}</li>
        <li class="list-group-item"><strong>Sexe :</strong> 
            {{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}
        </li>
        <li class="list-group-item"><strong>Date de naissance :</strong> 
            {{ $eleve->date_naissance }}
        </li>
        <li class="list-group-item"><strong>Lieu de naissance :</strong> {{ $eleve->lieu_naissance ?? '—' }}</li>
        <li class="list-group-item"><strong>Adresse :</strong> {{ $eleve->adresse ?? '—' }}</li>
        <li class="list-group-item"><strong>Nom du père :</strong> {{ $eleve->nom_pere ?? '—' }}</li>
        <li class="list-group-item"><strong>Nom de la mère :</strong> {{ $eleve->nom_mere ?? '—' }}</li>
        <li class="list-group-item"><strong>Tuteur :</strong> 
            {{ $eleve->tuteur ? $eleve->tuteur->nom_complet : '—' }}
        </li>
        <li class="list-group-item"><strong>Classe :</strong> 
            {{ $eleve->classe ? $eleve->classe->nom : 'Non assignée' }}
        </li>
        <li class="list-group-item"><strong>Statut :</strong> 
            @if($eleve->statut === 'actif')
                <span class="badge bg-success">Actif</span>
            @elseif($eleve->statut === 'absent')
                <span class="badge bg-warning text-dark">Absent</span>
            @else
                <span class="badge bg-danger">Abandon</span>
            @endif
        </li>
       
    </ul>

    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('eleve.index') }}" class="btn btn-secondary">Retour</a>
        <a href="{{ route('eleve.edit', $eleve->id) }}" class="btn btn-warning">Modifier</a>
        <form action="{{ route('eleve.delete', $eleve->id) }}" method="POST" 
              onsubmit="return confirm('Voulez-vous vraiment supprimer cet élève ?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>
@endsection
