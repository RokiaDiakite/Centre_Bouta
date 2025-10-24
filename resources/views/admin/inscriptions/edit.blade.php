@extends('layouts.admin')

@section('title', 'Modifier Inscription')

@section('content')

<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-4">Modifier Inscription</h2>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Progress Bar -->
            <div class="progress mb-4">
                <div class="progress-bar" role="progressbar" style="width: 33%;" id="progressBar">Étape 1 / 3</div>
            </div>

            <form id="inscriptionForm" action="{{ route('inscription.update', $inscription->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $inscription->id }}">

                <!-- Étape 1 : Élève -->
                <div class="step step-1">
                    <h4>Élève</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Nom</label>
                            <input type="text" name="eleve_nom" class="form-control" value="{{ $inscription->eleve->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Prénom</label>
                            <input type="text" name="eleve_prenom" class="form-control" value="{{ $inscription->eleve->prenom }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Date de naissance</label>
                            <input type="date" name="eleve_date_naissance" class="form-control" value="{{ $inscription->eleve->date_naissance }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Lieu de naissance</label>
                            <input type="text" name="eleve_lieu_naissance" class="form-control" value="{{ $inscription->eleve->lieu_naissance }}">
                        </div>
                        <div class="col-md-12 mb-3"><label>Adresse</label>
                            <input type="text" name="eleve_adresse" class="form-control" value="{{ $inscription->eleve->adresse }}">
                        </div>
                        <div class="col-md-6 mb-3"><label>Nom père</label>
                            <input type="text" name="eleve_nom_pere" class="form-control" value="{{ $inscription->eleve->nom_pere }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Nom mère</label>
                            <input type="text" name="eleve_nom_mere" class="form-control" value="{{ $inscription->eleve->nom_mere }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Sexe</label>
                            <select name="eleve_sexe" class="form-control" required>
                                <option value="M" {{ $inscription->eleve->sexe == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ $inscription->eleve->sexe == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3"><label>Statut</label>
                            <select name="eleve_statut" class="form-control" required>
                                <option value="actif" {{ $inscription->eleve->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="absent" {{ $inscription->eleve->statut == 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="abandon" {{ $inscription->eleve->statut == 'abandon' ? 'selected' : '' }}>Abandon</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary next-step">Suivant</button>
                </div>

                <!-- Étape 2 : Tuteur -->
                <div class="step step-2" style="display:none;">
                    <h4>Tuteur</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Nom</label>
                            <input type="text" name="tuteur_nom" class="form-control" value="{{ $inscription->eleve->tuteur->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Prénom</label>
                            <input type="text" name="tuteur_prenom" class="form-control" value="{{ $inscription->eleve->tuteur->prenom }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Email</label>
                            <input type="email" name="tuteur_email" class="form-control" value="{{ $inscription->eleve->tuteur->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3"><label>Mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="tuteur_password" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3"><label>Adresse</label>
                            <input type="text" name="tuteur_adresse" class="form-control" value="{{ $inscription->eleve->tuteur->adresse }}">
                        </div>
                        <div class="col-md-6 mb-3"><label>Numéro</label>
                            <input type="text" name="tuteur_numero" class="form-control" value="{{ $inscription->eleve->tuteur->numero }}">
                        </div>
                        <div class="col-md-6 mb-3"><label>Nom utilisateur</label>
                            <input type="text" name="tuteur_username" class="form-control" value="{{ $inscription->eleve->tuteur->username }}">
                        </div>
                        <div class="col-md-6 mb-3"><label>Profession</label>
                            <input type="text" name="tuteur_profession" class="form-control" value="{{ $inscription->eleve->tuteur->profession }}">
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                    <button type="button" class="btn btn-primary next-step">Suivant</button>
                </div>

                <!-- Étape 3 : Inscription -->
                <div class="step step-3" style="display:none;">
                    <h4>Inscription</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Classe</label>
                            <select name="classe_id" class="form-control" required>
                                @foreach($classes as $classe)
                                <option value="{{ $classe->id }}" {{ $inscription->classe_id == $classe->id ? 'selected' : '' }}>{{ $classe->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Année scolaire</label>
                            <select name="annee_scolaire_id" class="form-control" required>
                                @foreach($annees as $annee)
                                <option value="{{ $annee->id }}" {{ $inscription->annee_scolaire_id == $annee->id ? 'selected' : '' }}>{{ $annee->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3"><label>Frais d’inscription</label>
                            <input type="number" name="frais_ins" class="form-control" step="0.01" min="0" value="{{ $inscription->frais_ins }}" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var totalSteps = 3;
        var currentStep = 1;

        function updateProgressBar() {
            var percent = (currentStep / totalSteps) * 100;
            $('#progressBar').css('width', percent + '%').text('Étape ' + currentStep + ' / ' + totalSteps);
        }

        $('.next-step').click(function() {
            $(this).closest('.step').hide().next('.step').show();
            currentStep++;
            updateProgressBar();
        });

        $('.prev-step').click(function() {
            $(this).closest('.step').hide().prev('.step').show();
            currentStep--;
            updateProgressBar();
        });
    });
</script>
@endsection