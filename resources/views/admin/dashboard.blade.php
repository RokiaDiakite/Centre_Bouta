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

    <!-- 🔽 Filtre année scolaire -->
    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <label for="annee_scolaire_id" class="fw-bold">Année scolaire :</label>
                <select name="annee_scolaire_id" id="annee_scolaire_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Année scolaire --</option>
                    @foreach($anneesScolaires as $a)
                    <option value="{{ $a->id }}" {{ $annee->id == $a->id ? 'selected' : '' }}>
                        {{ $a->libelle }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    <!-- 📊 Tableau statistiques par classe -->
    <div class="card mt-4">
        <div class="card-header text-white text-center bg-primary">
            <h5>Statistiques par Classe — Année scolaire {{ $annee->libelle }}</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>Classe</th>
                        <th>Total élèves</th>
                        <th>Garçons</th>
                        <th>Filles</th>
                        <th>Chiffre d’affaires (attendu)</th>
                        <th>Montant payé</th>
                        <th>Reliquat</th>
                        <th>Paiement Maîtres</th>
                        <th>Dépenses</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statsParClasse as $stat)
                    <tr>
                        <td>{{ $stat['nom'] }}</td>
                        <td>{{ $stat['total'] }}</td>
                        <td>{{ $stat['garcons'] }}</td>
                        <td>{{ $stat['filles'] }}</td>
                        <td>{{ number_format($stat['chiffreAffaires'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($stat['montantPaye'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($stat['reliquat'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($stat['paiementMaitre'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($stat['depense'], 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-secondary fw-bold">
                    <tr>
                        <td>Total</td>
                        <td>{{ $totaux['nbEleves'] }}</td>
                        <td>{{ $nbGarcons }}</td>
                        <td>{{ $nbFilles }}</td>
                        <td>{{ number_format($totaux['chiffreAffaires'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($totaux['montantPaye'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($totaux['reliquat'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($totaux['paiementMaitre'], 0, ',', ' ') }} FCFA</td>
                        <td>{{ number_format($totaux['depense'], 0, ',', ' ') }} FCFA</td>
                    </tr>

                    <!-- 📉 Taux d’inscription -->
                    <tr class="table-info text-center">
                        <td colspan="9">
                            📈 <strong>Taux d’inscription par rapport à {{ $anneeReference->libelle ?? 'l’année précédente' }} :</strong>
                            <span class="text-primary">{{ $comparaison['nbEleves'] ?? 0 }} %</span>
                        </td>
                    </tr>

                    <!-- 💼 État du chiffre d’affaires -->
                    <tr class="table-warning text-center">
                        <td colspan="9">
                            💼 <strong>État du chiffre d’affaires par rapport à {{ $anneeReference->libelle ?? 'l’année précédente' }} :</strong>
                            <span class="text-success">{{ $comparaison['chiffreAffaires'] ?? 0 }} %</span>
                        </td>
                    </tr>

                    <!-- 💰 Taux de recouvrement -->
                    <tr class="table-success text-center">
                        <td colspan="9">
                            💰 <strong>Taux de recouvrement :</strong>
                            <span class="text-danger">{{ $tauxRecouvrement }} %</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <hr>

    <!-- 📈 Graphiques -->
    <div class="row mt-5">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center fw-bold">
                    Répartition Filles / Garçons
                </div>
                <div class="card-body">
                    <canvas id="sexeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header text-center fw-bold">
                    Paiements vs Dépenses
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
                <div class="card-header text-center fw-bold">
                    Nombre d'élèves par classe
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

        // ✅ Répartition Filles / Garçons
        new Chart(document.getElementById('sexeChart'), {
            type: 'doughnut',
            data: {
                labels: @json($sexeChartData['labels']),
                datasets: [{
                    data: @json($sexeChartData['data']),
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

        // ✅ Paiements vs Dépenses
        new Chart(document.getElementById('financeChart'), {
            type: 'bar',
            data: {
                labels: @json($financeChartData['labels']),
                datasets: [{
                    label: 'Montant (FCFA)',
                    data: @json($financeChartData['data']),
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

        // ✅ Nombre d'élèves par classe
        new Chart(document.getElementById('classeChart'), {
            type: 'bar',
            data: {
                labels: @json($classeChartData['labels']),
                datasets: [{
                    label: "Nombre d'élèves",
                    data: @json($classeChartData['data']),
                    backgroundColor: '#2980b9'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>
@endsection