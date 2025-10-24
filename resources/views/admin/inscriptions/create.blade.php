@extends('layouts.admin')

@section('title', 'Nouvelle Inscription')

@section('content')

<div class="container-fluid py-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-4">Nouvelle Inscription</h2>

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

            <form id="inscriptionForm" action="{{ route('inscription.store') }}" method="POST">
                @csrf

                <!-- Étape 1 : Élève -->
                <div class="step step-1">
                    <h4>Élève</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Nom</label><input type="text" name="eleve_nom" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Prénom</label><input type="text" name="eleve_prenom" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Date de naissance</label><input type="date" name="eleve_date_naissance" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Lieu de naissance</label><input type="text" name="eleve_lieu_naissance" class="form-control"></div>
                        <div class="col-md-12 mb-3"><label>Adresse</label><input type="text" name="eleve_adresse" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Nom père</label><input type="text" name="eleve_nom_pere" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Nom mère</label><input type="text" name="eleve_nom_mere" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Sexe</label>
                            <select name="eleve_sexe" class="form-control" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3"><label>Statut</label>
                            <select name="eleve_statut" class="form-control" required>
                                <option value="">-- Sélectionnez --</option>
                                <option value="actif">Actif</option>
                                <option value="absent">Absent</option>
                                <option value="abandon">Abandon</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary next-step">Suivant</button>
                </div>

                <!-- Étape 2 : Tuteur -->
                <div class="step step-2" style="display:none;">
                    <h4>Tuteur</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Nom</label><input type="text" name="tuteur_nom" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Prénom</label><input type="text" name="tuteur_prenom" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Email</label><input type="email" name="tuteur_email" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Mot de passe</label><input type="password" name="tuteur_password" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Adresse</label><input type="text" name="tuteur_adresse" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Numéro</label><input type="text" name="tuteur_numero" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Nom utilisateur</label><input type="text" name="tuteur_username" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Profession</label><input type="text" name="tuteur_profession" class="form-control"></div>
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
                                <option value="">-- Sélectionnez --</option>
                                @foreach($classes as $classe)
                                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Année scolaire</label>
                            <select name="annee_scolaire_id" class="form-control" required>
                                <option value="">-- Sélectionnez --</option>
                                @foreach($annees as $annee)
                                <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3"><label>Frais d’inscription</label><input type="number" name="frais_ins" class="form-control" step="0.01" min="0" required></div>
                    </div>
                    <button type="button" class="btn btn-secondary prev-step">Précédent</button>
                    <button type="submit" class="btn btn-success">Terminer l’inscription</button>
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