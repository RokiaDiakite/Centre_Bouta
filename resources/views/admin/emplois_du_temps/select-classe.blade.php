@extends('layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h3>Choisir une classe</h3>
    <a href="{{ route('emploi.index') }}" class="btn btn-primary mb-3">Retour</a>
    <ul class="list-group">
        @foreach($classes as $classe)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('emploi.classe.show', $classe->id) }}">{{ $classe->nom }}</a>
            <a href="{{ route('emploi.classe.print', $classe->id) }}" class="btn btn-sm btn-success">🖨️ PDF</a>

        </li>
        @endforeach
    </ul>
</div>
@endsection