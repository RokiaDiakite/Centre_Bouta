@extends('layouts.tuteur')

@section('title', 'Détails paiements')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4>Détails des paiements de {{ $eleve->nom }} {{ $eleve->prenom }}</h4>

    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('tuteur.frais_scolaire.index') }}" class="btn btn-secondary me-2">← Retour</a>
        <!-- <a href="#" class="btn btn-success">Télécharger PDF</a> -->
    </div>

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
        <table class="table table-bordered text-center">
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
                    <td>{{ \Carbon\Carbon::parse($p->date_paiement ?? $p->created_at)->format('d/m/Y') }}</td>
                    <td>{{ number_format($p->montant_paye ?? $p->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ ucfirst($p->mode_de_paiement ?? '-') }}</td>
                    <td>{{ $p->numero_recu ?? '-' }}</td>
                    <td>
                        @if(!empty($p->fichier_pdf))
                        @if(\Illuminate\Support\Str::endsWith($p->fichier_pdf, '.pdf'))
                        <a href="{{ asset('storage/'.$p->fichier_pdf) }}" target="_blank">📄 Voir PDF</a>
                        @else
                        <a href="{{ asset('storage/'.$p->fichier_pdf) }}" target="_blank">
                            <img src="{{ asset('storage/'.$p->fichier_pdf) }}" width="60" height="60"
                                style="object-fit:cover; border-radius:5px;">
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
        Aucun paiement trouvé pour cet élève.
    </div>
    @endif
</div>
@endsection