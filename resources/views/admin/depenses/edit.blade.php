@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Modifier une Dépense</h4>
    <a href="{{ route('depense.index') }}" class="btn btn-secondary mb-3">Retour</a>

    <div class="card p-4">
        <form action="{{ route('depense.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $depense->id }}">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Année scolaire</label>
                    <select name="annee_scolaire_id" class="form-select" required>
                        @foreach($annees as $a)
                        <option value="{{ $a->id }}" {{ $depense->annee_scolaire_id == $a->id ? 'selected' : '' }}>
                            {{ $a->libelle }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" value="{{ $depense->date }}" required>
                </div>

                <div class="col-md-4">
                    <label>Montant</label>
                    <input type="number" name="montant" class="form-control" value="{{ $depense->montant }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Intitulé</label>
                <input type="text" name="intitule" class="form-control" value="{{ $depense->intitule }}" required>
            </div>

            <div class="mb-3">
                <label>Justificatif (PDF/Image)</label>
                <input type="file" name="fichier_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                @if($depense->fichier_pdf)
                <div class="mt-2">
                    <a href="{{ asset('storage/'.$depense->fichier_pdf) }}" target="_blank">📎 Voir fichier actuel</a>
                </div>
                @endif
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
