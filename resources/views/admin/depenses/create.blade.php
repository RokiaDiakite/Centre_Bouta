@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Ajouter une Dépense</h4>
    <a href="{{ route('depense.index') }}" class="btn btn-secondary mb-3">Retour</a>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('depense.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Année scolaire</label>
                    <select name="annee_scolaire_id" class="form-select" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($annees as $a)
                        <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label>Montant</label>
                    <input type="number" name="montant" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Intitulé</label>
                <input type="text" name="intitule" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Justificatif (PDF/Image)</label>
                <input type="file" name="fichier_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
