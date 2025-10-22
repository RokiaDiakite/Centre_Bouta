@extends('layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Tables /</span> Modifier la Matière
    </h4>

    <div class="card p-3">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('matiere.update', $matiere->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{$matiere->id}}">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la matière</label>
                <input type="text" class="form-control" id="nom" name="nom"
                    value="{{ old('nom', $matiere->nom) }}" required>
            </div>

            <div class="mb-3">
                <label for="coefficient" class="form-label">Coefficient</label>
                <input type="number" class="form-control" id="coefficient" name="coefficient"
                    value="{{ old('coefficient', $matiere->coefficient) }}" required>
            </div>

            <div class="mb-3">
                <label for="classes" class="form-label">Choisir les classes</label>
                <select name="classes[]" id="classes" class="form-select" multiple required>
                    @foreach($classes as $classe)
                    <option value="{{ $classe->id }}"
                        {{ in_array($classe->id, old('classes', $matiere->classes->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $classe->nom }}
                    </option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Maintenez Ctrl ou Cmd pour sélectionner plusieurs classes</small>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('matiere.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection