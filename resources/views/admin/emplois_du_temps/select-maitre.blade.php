@extends('layouts.admin')
@section('content')
<h3>Choisir un maitre</h3>
<ul class="list-group">
    @foreach($maitres as $maitre)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('emploi.index') }}" class="btn btn-warning mb-3">Retour</a>
        <a href="{{ route('emploi.maitre.show', $maitre->id) }}">{{ $maitre->nom }} {{ $maitre->prenom }}</a>
        <a href="{{ route('emploi.maitre.print', $maitre->id) }}" class="btn btn-sm btn-success">🖨️ PDF</a>


    </li>
    @endforeach
</ul>
@endsection