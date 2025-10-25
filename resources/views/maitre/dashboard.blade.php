@extends('layouts.maitre')

@section('title', 'Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h2 class="mb-4">Bienvenue, Monsieur {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>

    <div class="row g-3">
       
        <!-- Emploi du temps -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-success h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Emploi du temps</h5>
                        <p class="display-6 mb-0">{{ $emplois_count }}</p>
                    </div>
                    <i class="fas fa-calendar-alt fa-3x"></i>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('maitre.emploi.index') }}" class="btn btn-light btn-sm">Voir</a>
                </div>
            </div>
        </div>

        <!-- Paiements récents -->
        <div class="col-md-6 col-lg-4">
            <div class="card text-white bg-info h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title">Paiements récents</h5>
                        <p class="mb-0">Consultez rapidement</p>
                    </div>
                    <i class="fas fa-money-bill-wave fa-3x"></i>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('maitre.paiement.index') }}" class="btn btn-light btn-sm">Voir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Options supplémentaires -->
    <div class="row mt-4 g-3">
        <div class="col-md-6">
            <div class="card border-secondary h-100">
                <div class="card-body">
                    <h5 class="card-title">Planification des cours</h5>
                    <p class="card-text">Accédez aux emplois du temps de vos enfants.</p>
                    <a href="{{ route('maitre.emploi.index') }}" class="btn btn-secondary btn-sm">Voir</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Statistiques des paiements</h5>
                    <p class="card-text">Consultez le résumé global des paiements de vos enfants.</p>
                    <a href="{{ route('maitre.paiement.index') }}" class="btn btn-warning btn-sm">Voir</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection