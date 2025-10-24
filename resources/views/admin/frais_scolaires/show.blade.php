@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Détails des paiements d’un élève</h4>

    <div class="card p-4">

        <form method="GET" action="{{ route('frais.statistique-eleve') }}" class="row g-3 mb-4">
            {{-- Année scolaire --}}
            <div class="col-md-3">
                <label class="form-label">Année scolaire</label>
                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-select" required>
                    <option value="">-- Choisir une année --</option>
                    @foreach($annees as $a)
                    <option value="{{ $a->id }}" {{ $anneeId == $a->id ? 'selected' : '' }}>
                        {{ $a->libelle }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Classe --}}
            <div class="col-md-3">
                <label class="form-label">Classe</label>
                <select name="classe_id" id="classe_id" class="form-select" required>
                    <option value="">-- Choisir une classe --</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ $classeId == $c->id ? 'selected' : '' }}>
                        {{ $c->nom }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Élève --}}
            <div class="col-md-3">
                <label class="form-label">Élève</label>
                <select name="eleve_id" id="eleve_id" class="form-select" required>
                    <option value="">-- Choisir un élève --</option>
                    @foreach($eleves as $e)
                    <option value="{{ $e->id }}" {{ $eleveId == $e->id ? 'selected' : '' }}>
                        {{ $e->matricule }} - {{ $e->nom }} {{ $e->prenom }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Bouton --}}
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Afficher</button>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                <a href="{{ route('frais.index') }}" class="btn btn-secondary me-2">Annuler</a>
            </div>
        </form>

        {{-- Tableau des paiements --}}
        @if($paiements->count())
        @php
        $totalPaye = $paiements->sum('montant_paye');
        $totalAttendu = $paiements->first()->montant_total ?? 0;
        $reliquat = $totalAttendu - $totalPaye;
        $pourcentage = $totalAttendu > 0 ? round(($totalPaye / $totalAttendu) * 100, 2) : 0;
        @endphp

        <div class="mb-4">
            <h5>📘 Résumé du paiement :</h5>
            <ul>
                <li><strong>Total à payer :</strong> {{ number_format($totalAttendu, 0, ',', ' ') }} FCFA</li>
                <li><strong>Total payé :</strong> {{ number_format($totalPaye, 0, ',', ' ') }} FCFA</li>
                <li><strong>Reliquat :</strong> {{ number_format($reliquat, 0, ',', ' ') }} FCFA</li>
                <li><strong>Progression :</strong>
                    <div class="progress" style="height: 20px; width: 300px;">
                        <div class="progress-bar {{ $pourcentage >= 100 ? 'bg-success' : 'bg-info' }}" role="progressbar"
                            style="width: {{ $pourcentage }}%;">
                            {{ $pourcentage }} %
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Date de paiement</th>
                        <th>Montant payé</th>
                        <th>Mode de paiement</th>
                        <th>Numéro de reçu</th>
                        <th>Justificatif</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $p)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($p->date_paiement)->format('d/m/Y') }}</td>
                        <td>{{ number_format($p->montant_paye, 0, ',', ' ') }} FCFA</td>
                        <td>{{ ucfirst($p->mode_de_paiement) }}</td>
                        <td>{{ $p->numero_recu }}</td>
                        <td>
                            @if($p->fichier_pdf)
                            @if(\Illuminate\Support\Str::endsWith($p->fichier_pdf, '.pdf'))
                            <a href="{{ asset('storage/'.$p->fichier_pdf) }}" target="_blank">📄 Voir PDF</a>
                            @else
                            <a href="{{ asset('storage/'.$p->fichier_pdf) }}" target="_blank">
                                <img src="{{ asset('storage/'.$p->fichier_pdf) }}" width="60" height="60" style="object-fit:cover; border-radius:5px;">
                            </a>
                            @endif
                            @else
                            <span class="text-muted">Aucun fichier</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <div class="alert alert-info text-center">
            Aucun paiement trouvé pour cette sélection.
        </div>
        @endif
    </div>
</div>

{{-- Script AJAX pour recharger les élèves selon la classe --}}
<script>
    function loadEleves() {
        const classeId = document.getElementById('classe_id').value;
        const anneeId = document.getElementById('annee_scolaire_id').value;
        const eleveSelect = document.getElementById('eleve_id');

        eleveSelect.innerHTML = '<option value="">Chargement...</option>';

        if (classeId && anneeId) {
            fetch(`{{ route('frais.eleve') }}?classe_id=${classeId}&annee_scolaire_id=${anneeId}`)
                .then(res => res.json())
                .then(data => {
                    eleveSelect.innerHTML = '<option value="">-- Choisir un élève --</option>';
                    data.forEach(eleve => {
                        eleveSelect.innerHTML += `<option value="${eleve.id}">${eleve.matricule ?? ''} - ${eleve.nom} ${eleve.prenom}</option>`;
                    });
                })
                .catch(() => eleveSelect.innerHTML = '<option value="">Erreur de chargement</option>');
        } else {
            eleveSelect.innerHTML = '<option value="">-- Choisir un élève --</option>';
        }
    }

    document.getElementById('classe_id').addEventListener('change', loadEleves);
    document.getElementById('annee_scolaire_id').addEventListener('change', loadEleves);
</script>
@endsection