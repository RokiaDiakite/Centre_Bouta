@extends('layouts.admin')
@section('content')
<div class="container">
    <h3>Gestion des Emplois du Temps</h3>

    <a href="{{ route('emploi.create') }}" class="btn btn-primary mb-3">➕ Ajouter un créneau</a>
    <a href="{{ route('emploi.select.classe') }}" class="btn btn-primary mb-3">📅 Voir par Classe</a>
    <a href="{{ route('emploi.select.maitre') }}" class="btn btn-primary mb-3">👨‍🏫 Voir par Maitre</a>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Jour</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Maitre</th>
                <th>Heure début</th>
                <th>Heure fin</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emplois as $edt)
            <tr>
                <td>{{ $edt->jour }}</td>
                <td>{{ $edt->classe->nom }}</td>
                <td>{{ $edt->matiere->nom }}</td>
                <td>{{ $edt->maitre->nom }} {{ $edt->maitre->prenom }}</td>
                <td>{{ $edt->heure_debut }}</td>
                <td>{{ $edt->heure_fin }}</td>
                <td>
                    <a href="{{ route('emploi.edit', $edt->id) }}" class="btn btn-warning btn-sm">✏️</a>
                    <form action="{{ route('emploi.delete', $edt->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        <button type="submit" onclick="return confirm('Supprimer ?')" class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
