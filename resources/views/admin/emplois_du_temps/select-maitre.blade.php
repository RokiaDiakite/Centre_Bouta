@extends('layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Choisir un maitre</h3>
    <a href="{{ route('emploi.index') }}" class="btn btn-primary mb-3">Retour</a>
    <ul class="list-group">
        @foreach($maitres as $maitre)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('emploi.maitre.show', $maitre->id) }}">{{ $maitre->nom }} {{ $maitre->prenom }}</a>
            <a href="{{ route('emploi.maitre.print', $maitre->id) }}" class="btn btn-sm btn-primary">🖨️ PDF</a>
        </li>
        @endforeach
    </ul>
</div>
@endsection