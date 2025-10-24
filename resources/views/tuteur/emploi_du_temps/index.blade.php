@extends('layouts.tuteur')
@section('content')
<div class="container mt-4">
    <h2>Mes enfants</h2>

    @if(session('info'))
    <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if($eleves->isEmpty())
    <p>Aucun élève associé.</p>
    @else
    <ul class="list-group">
        @foreach($eleves as $eleve)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $eleve->nom }} {{ $eleve->prenom }} ({{ $eleve->classe->nom ?? '-' }})
            <span>
                <a href="{{ route('tuteur.emplois.show', $eleve->id) }}" class="btn btn-primary btn-sm">Voir</a><!-- 
                <a href="{{ route('tuteur.emplois.download', $eleve->id) }}" class="btn btn-success btn-sm">Télécharger PDF</a> -->
            </span>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection