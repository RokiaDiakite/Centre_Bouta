@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Ajouter un paiement scolaire</h4>

    <div class="card p-4">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('frais.store') }}" method="POST" enctype="multipart/form-data" id="formFrais">
            @csrf

            <div class="row mb-3">
                {{-- Année scolaire --}}
                <div class="col-md-4">
                    <label for="annee_scolaire_id" class="form-label">Année scolaire</label>
                    <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select" required>
                        <option value="">-- Sélectionner une année --</option>
                        @foreach($annees as $a)
                        <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Classe --}}
                <div class="col-md-4">
                    <label for="classe_id" class="form-label">Classe</label>
                    <select name="classe_id" id="classe_id" class="form-select" required>
                        <option value="">-- Sélectionner une classe --</option>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Élève --}}
                <div class="col-md-4">
                    <label for="eleve_id" class="form-label">Élève</label>
                    <select name="eleve_id" id="eleve_id" class="form-select" required>
                        <option value="">-- Sélectionner un élève --</option>
                        {{-- Les options seront injectées par JS après sélection année+classe --}}
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="montant_total" class="form-label">Montant total (automatique)</label>
                    <input type="number" class="form-control" id="montant_total" readonly>
                </div>
                <div class="col-md-4">
                    <label for="montant_paye" class="form-label">Montant payé</label>
                    <input type="number" name="montant_paye" id="montant_paye" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="date_paiement" class="form-label">Date de paiement</label>
                    <input type="date" name="date_paiement" id="date_paiement" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="mode_de_paiement" class="form-label">Mode de paiement</label>
                    <select name="mode_de_paiement" id="mode_de_paiement" class="form-select" required>
                        <option value="">-- Sélectionner un mode --</option>
                        <option value="chèque">Chèque</option>
                        <option value="espèce">Espèce</option>
                        <option value="orange money">Orange Money</option>
                        <option value="wave">Wave</option>
                        <option value="moov money">Moov Money</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="numero_recu" class="form-label">Numéro de reçu</label>
                    <input type="text" name="numero_recu" id="numero_recu" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="fichier_pdf" class="form-label">Justificatif (PDF/Image)</label>
                    <input type="file" name="fichier_pdf" id="fichier_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ route('frais.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

{{-- Script AJAX pour charger élèves et montant automatiquement --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classeSelect = document.getElementById('classe_id');
        const eleveSelect = document.getElementById('eleve_id');
        const montantTotal = document.getElementById('montant_total');

        // Charger les élèves quand la classe change
        classeSelect.addEventListener('change', function() {
            const classeId = this.value;

            if (classeId) {
                // Charger les élèves de la classe
                fetch(`{{ route('frais.eleve') }}?classe_id=${classeId}`)
                    .then(res => res.json())
                    .then(data => {
                        eleveSelect.innerHTML = '<option value="">-- Sélectionner un élève --</option>';
                        data.forEach(eleve => {
                            eleveSelect.innerHTML += `<option value="${eleve.id}">${eleve.matricule ?? ''} - ${eleve.nom} ${eleve.prenom}</option>`;
                        });
                    })
                    .catch(err => console.error('Erreur chargement élèves:', err));

                // Charger le montant total de la classe
                fetch(`{{ route('frais.getFrais', '') }}/${classeId}`)
                    .then(res => res.json())
                    .then(data => {
                        montantTotal.value = data.frais ?? 0;
                    })
                    .catch(err => console.error('Erreur chargement montant:', err));
            } else {
                eleveSelect.innerHTML = '<option value="">-- Sélectionner un élève --</option>';
                montantTotal.value = '';
            }
        });
    });
</script>


@endsection