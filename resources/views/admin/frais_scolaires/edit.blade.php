@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Modifier un paiement scolaire</h4>

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

        <form action="{{ route('frais.update', $frais->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="classe_id" class="form-label">Classe</label>
                    <select name="classe_id" id="classe_id" class="form-select" required>
                        @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ $frais->classe_id == $c->id ? 'selected' : '' }}>
                            {{ $c->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="eleve_id" class="form-label">Élève</label>
                    <select name="eleve_id" id="eleve_id" class="form-select" required>
                        @foreach($eleves as $e)
                        <option value="{{ $e->id }}" {{ $frais->eleve_id == $e->id ? 'selected' : '' }}>
                            {{ $e->matricule }} - {{ $e->nom }} {{ $e->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="annee_scolaire_id" class="form-label">Année scolaire</label>
                    <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select" required>
                        @foreach($annees as $a)
                        <option value="{{ $a->id }}" {{ $frais->annee_scolaire_id == $a->id ? 'selected' : '' }}>
                            {{ $a->libelle }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Montant total</label>
                    <input type="number" class="form-control" value="{{ $frais->montant_total }}" readonly>
                </div>
                <div class="col-md-4">
                    <label for="montant_paye" class="form-label">Montant payé</label>
                    <input type="number" name="montant_paye" id="montant_paye" class="form-control" value="{{ $frais->montant_paye }}" required>
                </div>
                <div class="col-md-4">
                    <label for="date_paiement" class="form-label">Date de paiement</label>
                    <input type="date" name="date_paiement" id="date_paiement" class="form-control" value="{{ $frais->date_paiement }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="mode_de_paiement" class="form-label">Mode de paiement</label>
                    <select name="mode_de_paiement" id="mode_de_paiement" class="form-select" required>
                        @foreach(['chèque','espèce','orange money','wave','moov money'] as $mode)
                        <option value="{{ $mode }}" {{ $frais->mode_de_paiement == $mode ? 'selected' : '' }}>
                            {{ ucfirst($mode) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="numero_recu" class="form-label">Numéro de reçu</label>
                    <input type="text" name="numero_recu" id="numero_recu" class="form-control" value="{{ $frais->numero_recu }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fichier_pdf" class="form-label">Justificatif (PDF/Image)</label>
                    <input type="file" name="fichier_pdf" id="fichier_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    @if($frais->fichier_pdf)
                    <div class="mt-2">
                        <a href="{{ asset('storage/'.$frais->fichier_pdf) }}" target="_blank">
                            📎 Voir le fichier actuel
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ route('frais.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

{{-- Script pour recharger les élèves si la classe change --}}
<script>
    document.getElementById('classe_id').addEventListener('change', function() {
        const classeId = this.value;
        const eleveSelect = document.getElementById('eleve_id');
        if (classeId) {
            fetch(`/admin/frais/get-eleves/${classeId}`)
                .then(res => res.json())
                .then(data => {
                    eleveSelect.innerHTML = '';
                    data.forEach(eleve => {
                        eleveSelect.innerHTML += `<option value="${eleve.id}">${eleve.matricule} - ${eleve.nom} ${eleve.prenom}</option>`;
                    });
                });
        }
    });
</script>
@endsection