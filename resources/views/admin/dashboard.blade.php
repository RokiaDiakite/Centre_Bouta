@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4">Tableau de bord</h2>
<form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="annee_scolaire_id">Année scolaire :</label>
            <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Toutes les années --</option>
                @foreach($anneesScolaires as $annee)
                    <option value="{{ $annee->id }}" {{ request('annee_scolaire_id') == $annee->id ? 'selected' : '' }}>
                        {{ $annee->libelle }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>

        <div class="row">
            <!-- Statistiques globales -->
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Élèves</h5>
                        <h3>{{ $totalEleves }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Professeurs</h5>
                        <h3>{{ $totalProfs }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total Paiements</h5>
                        <h3>{{ number_format($totalPaiements, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total Dépenses</h5>
                        <h3>{{ number_format($totalDepenses, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Paiements Maîtres</h5>
                        <h3>{{ number_format($totalPaiementsMaitres, 0, ',', ' ') }} FCFA</h3>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- Répartition filles / garçons -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Garçons</h5>
                        <h3>{{ $nbGarcons }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Filles</h5>
                        <h3>{{ $nbFilles }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- Statistiques par classe -->
        <h4 class="mt-4">Statistiques par classe</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Classe</th>
                    <th>Nombre d'élèves</th>
                    <th>Garçons</th>
                    <th>Filles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statsParClasse as $classe)
                    <tr>
                        <td>{{ $classe['nom'] }}</td>
                        <td>{{ $classe['total'] }}</td>
                        <td>{{ $classe['garcons'] }}</td>
                        <td>{{ $classe['filles'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>

<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <strong>Répartition Filles / Garçons</strong>
            </div>
            <div class="card-body">
                <canvas id="sexeChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <strong>Paiements vs Dépenses</strong>
            </div>
            <div class="card-body">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header text-center">
                <strong>Nombre d'élèves par classe</strong>
            </div>
            <div class="card-body">
                <canvas id="classeChart"></canvas>
            </div>
        </div>
    </div>
</div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {

    // === 1️⃣ Répartition filles / garçons ===
    const sexeCtx = document.getElementById('sexeChart').getContext('2d');
    new Chart(sexeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Garçons', 'Filles'],
            datasets: [{
                data: [{{ $nbGarcons }}, {{ $nbFilles }}],
                backgroundColor: ['#3498db', '#e74c3c'],
                hoverOffset: 10
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // === 2️⃣ Paiements vs Dépenses ===
    const financeCtx = document.getElementById('financeChart').getContext('2d');
    new Chart(financeCtx, {
        type: 'bar',
        data: {
            labels: ['Paiements', 'Dépenses', 'Paiements Maîtres'],
            datasets: [{
                label: 'Montant (FCFA)',
                data: [{{ $totalPaiements }}, {{ $totalDepenses }}, {{ $totalPaiementsMaitres }}],
                backgroundColor: ['#2ecc71', '#e67e22', '#9b59b6']
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // === 3️⃣ Élèves par classe ===
    const classeCtx = document.getElementById('classeChart').getContext('2d');
    new Chart(classeCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($statsParClasse->pluck('nom')) !!},
            datasets: [{
                label: "Nombre d'élèves",
                data: {!! json_encode($statsParClasse->pluck('total')) !!},
                backgroundColor: '#2980b9'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

});
</script>
@endsection

