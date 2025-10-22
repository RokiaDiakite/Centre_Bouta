@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center">Sélection du bulletin</h2>

    <form action="{{ route('bulletin.show') }}" method="GET">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="classe" class="form-label">Classe</label>
                <select name="classe" id="classe" class="form-control" required>
                    <option value="">-- Sélectionnez une classe --</option>
                    @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="annee" class="form-label">Année scolaire</label>
                <select name="annee" id="annee" class="form-control" required>
                    <option value="">-- Sélectionnez une année --</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="evaluation" class="form-label">Évaluation</label>
                <select name="evaluation" id="evaluation" class="form-control" required>
                    <option value="">-- Sélectionnez une évaluation --</option>
                    @foreach($evaluations as $evaluation)
                    <option value="{{ $evaluation->id }}">{{ $evaluation->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-primary">📄 Voir le bulletin</button>
        </div>
    </form>

    <hr class="my-4">

    {{-- Formulaire pour imprimer tous les bulletins --}}
    <form action="{{ route('bulletin.print-all') }}" method="GET" class="text-center mt-3">
        <div class="row mb-3 justify-content-center">
            <div class="col-md-3">
                <select name="classe" class="form-control" required>
                    <option value="">-- Classe --</option>
                    @foreach($classes as $classe)
                    <option value="{{ $classe->id }}">{{ $classe->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="annee" class="form-control" required>
                    <option value="">-- Année scolaire --</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="evaluation" class="form-control" required>
                    <option value="">-- Évaluation --</option>
                    @foreach($evaluations as $evaluation)
                    <option value="{{ $evaluation->id }}">{{ $evaluation->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-success">
            🖨 Imprimer tous les bulletins
        </button>
    </form>
</div>
@endsection