@extends("layouts.admin")
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Modification d'eleves</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Modifier un élève</h5>
                    <a class="btn btn-secondary float-end" href="{{route('eleve.index')}}">retour</a>
                </div>
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>

                        @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>

                        @endforeach
                    </ul>
                </div>

                @endif

                <div class="card-body">
                    <form action="{{ route('eleve.update', $eleve->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$eleve->id}}">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Matricule</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->matricule}}" name="matricule" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->nom}}" name="nom" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Prenom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->prenom}}" name="prenom" placeholder="" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Date Naissance</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->date_naissance}}" name="date_naissance" placeholder="" />
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Lieu Naissance</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->lieu_naissance}}" name="lieu_naissance" placeholder="" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Adresse</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->adresse}}" name="adresse" placeholder="" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nom père</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->nom_pere}}" name="nom_pere" placeholder="" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Nom mère</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="basic-default-name" value="{{$eleve->nom_mere}}" name="nom_mere" placeholder="" />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Sexe</label>
                                <select name="eleve_sexe" class="form-control" required>
                                    <option value="">-- Sélectionnez --</option>
                                    <option value="M" {{ old('eleve_sexe', $eleve->sexe ?? '') == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('eleve_sexe', $eleve->sexe ?? '') == 'F' ? 'selected' : '' }}>Féminin</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Statut</label>
                                <select name="eleve_statut" class="form-control" required>
                                    <option value="">-- Sélectionnez --</option>
                                    <option value="actif" {{ old('eleve_statut', $eleve->statut ?? '') == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="absent" {{ old('eleve_statut', $eleve->statut ?? '') == 'absent' ? 'selected' : '' }}>Absent</option>
                                    <option value="abandon" {{ old('eleve_statut', $eleve->statut ?? '') == 'abandon' ? 'selected' : '' }}>Abandon</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Tuteur</label>
                                <select name="tuteur_id" class="form-control" required>
                                    @foreach ($tuteurs as $tuteur)
                                    <option value="{{ $tuteur->id }}" {{ $eleve->tuteur_id == $tuteur->id ? 'selected' : '' }}>
                                        {{ $tuteur->nom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Classe</label>
                                <select name="classe_id" class="form-control" required>
                                    @foreach ($classes as $classe)
                                    <option value="{{ $classe->id }}" {{ $eleve->classe_id == $classe->id ? 'selected' : '' }}>
                                        {{ $classe->nom }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Modifier</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection