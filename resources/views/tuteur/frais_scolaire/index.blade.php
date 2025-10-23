@extends('layouts.tuteur')

@section('title', 'Mes élèves')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Mes enfants</h4>
    @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if($eleves->isEmpty())
    <div class="alert alert-info">Aucun élève associé.</div>
    @else
    <ul class="list-group">
        @foreach($eleves as $eleve)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $eleve->nom }} {{ $eleve->prenom }} ({{ $eleve->classe->nom ?? '-' }})
            <span>
                <a href="{{ route('tuteur.frais_scolaire.show', $eleve->id) }}" class="btn btn-primary btn-sm">
                    Voir paiements
                </a>
            </span>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection