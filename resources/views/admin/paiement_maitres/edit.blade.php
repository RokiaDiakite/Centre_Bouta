@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Modifier un paiement de maître</h4>

    <div class="card p-4">
        @if($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('paiement-maitre.update', $paiement->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="annee_scolaire_id" class="form-label">Année scolaire</label>
                    <select name="annee_scolaire_id" class="form-select" required>
                        @foreach($annees as $a)
                        <option value="{{ $a->id }}" {{ $paiement->annee_scolaire_id == $a->id ? 'selected' : '' }}>
                            {{ $a->libelle }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="maitre_id" class="form-label">Maître</label>
                    <select name="maitre_id" id="maitre_id" class="form-select" required onchange="updateMontant()">
                        @foreach($maitres as $m)
                        <option value="{{ $m->id }}" data-salaire="{{ $m->salaire }}" {{ $paiement->maitre_id == $m->id ? 'selected' : '' }}>
                            {{ $m->nom }} {{ $m->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="number" name="montant" id="montant" class="form-control" value="{{ $paiement->montant }}" readonly>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="mois" class="form-label">Mois</label>
                    <select name="mois" id="mois" class="form-select" required>
                        @php
                        $mois = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
                        @endphp
                        @foreach($mois as $m)
                        <option value="{{ $m }}" {{ $paiement->mois == $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="date_paiement" class="form-label">Date de paiement</label>
                    <input type="date" name="date_paiement" class="form-control" value="{{ $paiement->date_paiement }}" required>
                </div>

                <div class="col-md-4">
                    <label for="mode_paiement" class="form-label">Mode de paiement</label>
                    <select name="mode_paiement" id="mode_paiement" class="form-select" required>
                        @foreach(['Chèque','Espèce','Orange Money','Wave','Moov Money'] as $mode)
                        <option value="{{ $mode }}" {{ $paiement->mode_paiement == $mode ? 'selected' : '' }}>{{ $mode }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ route('paiement-maitre.index') }}" class="btn btn-secondary me-2">Annuler</a>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateMontant() {
        const select = document.getElementById('maitre_id');
        const montantInput = document.getElementById('montant');
        const selected = select.options[select.selectedIndex];
        montantInput.value = selected.dataset.salaire || '';
    }
</script>
@endsection