@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mx-auto" style="max-width: 900px; padding: 20px;">
        <h4 class="fw-bold py-3 mb-4 text-center">
            {{ isset($eleve) ? 'Modifier un élève' : 'Ajouter un élève' }}
        </h4>

        @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ isset($eleve) ? route('eleve.update', $eleve->id) : route('eleve.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label>Matricule</label>
                    <input type="text" name="matricule" value="{{ $eleve->matricule ?? '' }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Nom</label>
                    <input type="text" name="nom" value="{{ $eleve->nom ?? '' }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Prénom</label>
                    <input type="text" name="prenom" value="{{ $eleve->prenom ?? '' }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Date naissance</label>
                    <input type="date" name="date_naissance" value="{{ $eleve->date_naissance ?? '' }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Lieu naissance</label>
                    <input type="text" name="lieu_naissance" value="{{ $eleve->lieu_naissance ?? '' }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Adresse</label>
                    <input type="text" name="adresse" value="{{ $eleve->adresse ?? '' }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Nom père</label>
                    <input type="text" name="nom_pere" value="{{ $eleve->nom_pere ?? '' }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Nom mère</label>
                    <input type="text" name="nom_mere" value="{{ $eleve->nom_mere ?? '' }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Sexe</label>
                    <select name="sexe" class="form-control" required>
                        <option value="M" {{ (isset($eleve) && $eleve->sexe=='M')?'selected':'' }}>Masculin</option>
                        <option value="F" {{ (isset($eleve) && $eleve->sexe=='F')?'selected':'' }}>Féminin</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Statut</label>
                    <select name="statut" class="form-control" required>
                        <option value="actif" {{ (isset($eleve) && $eleve->statut=='actif')?'selected':'' }}>Actif</option>
                        <option value="absent" {{ (isset($eleve) && $eleve->statut=='absent')?'selected':'' }}>Absent</option>
                        <option value="abandon" {{ (isset($eleve) && $eleve->statut=='abandon')?'selected':'' }}>Abandon</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Tuteur</label>
                    <select name="tuteur_id" class="form-control" required>
                        @foreach($tuteurs as $tuteur)
                        <option value="{{ $tuteur->id }}" {{ (isset($eleve) && $eleve->tuteur_id==$tuteur->id)?'selected':'' }}>
                            {{ $tuteur->nom }} {{ $tuteur->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Classe</label>
                    <select name="classe_id" class="form-control">
                        <option value="">-- Choisir --</option>
                        @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ (isset($eleve) && $eleve->classe_id==$classe->id)?'selected':'' }}>
                            {{ $classe->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">{{ isset($eleve) ? 'Enregistrer' : 'Ajouter' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection