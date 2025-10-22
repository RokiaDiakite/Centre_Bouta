@extends('layouts.admin')
@section('title', 'Imprimer tous les bulletins')
@section('content')

<div class="container mt-2">

    <!-- Formulaire de sélection -->
    <div class="card p-2 shadow-sm mx-auto" style="max-width: 800px;">
        <h5 class="text-center mb-2">Imprimer tous les bulletins</h5>
        <a href="{{ route('bulletin.select') }}" class="btn btn-secondary btn-sm">⬅ Annuler / Retour</a>

        <form action="{{ route('bulletin.print-all') }}" method="get">
            @csrf
            <div class="row mb-2">
                <div class="col">
                    <label for="annee">Année scolaire</label>
                    <select name="annee" id="annee" class="form-select form-select-sm" required>
                        @foreach($annees as $annee)
                        <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="evaluation">Évaluation</label>
                    <select name="evaluation" id="evaluation" class="form-select form-select-sm" required>
                        @foreach($evaluations as $evaluation)
                        <option value="{{ $evaluation->id }}">{{ $evaluation->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="classe">Classe</label>
                    <select name="classe" id="classe" class="form-select form-select-sm" required>
                        @foreach($classes as $classe)
                        <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="text-center mb-2">
                <button type="submit" class="btn btn-primary btn-sm">Afficher les bulletins</button>
            </div>
        </form>
    </div>

    @if(isset($eleves) && count($eleves))
    <!-- Boutons Imprimer / Retour -->
    <div class="text-center mb-2 no-print">
        <button onclick="window.print()" class="btn btn-success btn-sm">🖨 Imprimer tous les bulletins</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">⬅ Annuler / Retour</a>
    </div>

    <!-- Bulletins -->
    <div class="bulletin-container" style="display:flex; flex-wrap:wrap; justify-content:space-between;">
        <h1>Complexe Scolaire Centre Bouta</h1>
        <h4>Bulletin Scolaire</h4>
        @foreach($eleves as $eleve)
        @php
        $notesEleve = $notes[$eleve->id] ?? [];
        $totalPondere = 0;
        $sommeCoef = 0;
        @endphp

        <div class="eleve" style="width:calc(50% - 5mm); padding:2mm; margin-bottom:5mm; page-break-inside:avoid; font-size:8px; border:1px dashed #aaa; position:relative;">

            <!-- Ligne de découpe horizontale si besoin -->
            <div style="position:absolute; top:0; left:0; width:100%; height:0; border-top:1px dashed #555;"></div>

            <h5 style="text-align:center; margin:0; font-size:10px;">{{ $eleve->nom }} {{ $eleve->prenom }} - {{ $classe->nom }}</h5>
            <p style="text-align:center; margin:1px 0;">Année: {{ $annee->libelle }} | Éval: {{ $evaluation->nom }} | Sexe: {{ $eleve->sexe }}</p>

            <table style="width:100%; border-collapse:collapse; font-size:7.5px; margin-top:1px;">
                <thead>
                    <tr>
                        <th>Matières</th>
                        <th>Dév</th>
                        <th>Comp</th>
                        <th>C</th>
                        <th>Md</th>
                        <th>Appr.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matieres as $matiere)
                    @php
                    $note = $notesEleve[$matiere->id] ?? null;
                    $devoir = floatval($note->note_devoir ?? 0);
                    $evalNote = floatval($note->note_evaluation ?? 0);
                    $coef = $matiere->coefficient ?? 1;
                    $moyenneMatiere = ($devoir + 2*$evalNote)/3;
                    $totalPondere += $moyenneMatiere * $coef;
                    $sommeCoef += $coef;

                    if($moyenneMatiere >= 16) $appMatiere = 'Excellent';
                    elseif($moyenneMatiere >= 14) $appMatiere = 'Très bien';
                    elseif($moyenneMatiere >= 12) $appMatiere = 'Bien';
                    elseif($moyenneMatiere >= 10) $appMatiere = 'Passable';
                    else $appMatiere = 'Insuffisant';
                    @endphp
                    <tr>
                        <td>{{ $matiere->nom }}</td>
                        <td>{{ $devoir ?: '-' }}</td>
                        <td>{{ $evalNote ?: '-' }}</td>
                        <td>{{ $coef }}</td>
                        <td>{{ number_format($moyenneMatiere,2) }}</td>
                        <td>{{ $appMatiere }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php $moyenneGenerale = $sommeCoef ? $totalPondere/$sommeCoef : 0; @endphp
                    <tr>
                        <th colspan="5">Moyenne Gén.</th>
                        <th>{{ number_format($moyenneGenerale,2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="5">Appréciation</th>
                        <th>
                            @php
                            if($moyenneGenerale < 10) $appreciation='Insuffisant' ;
                                elseif($moyenneGenerale < 12) $appreciation='Passable' ;
                                elseif($moyenneGenerale < 14) $appreciation='Assez bien' ;
                                elseif($moyenneGenerale < 16) $appreciation='Bien' ;
                                else $appreciation='Très bien' ;
                                @endphp
                                {{ $appreciation }}
                                </th>
                    </tr>
                </tfoot>
            </table>

            <div style="display:flex; justify-content:space-between; margin-top:2px; font-size:7.5px;">
                <div>Le Directeur<br>______</div>
                <div>Les Parents<br>______</div>
            </div>

            <div style="text-align:center; font-style:italic; color:#1e90ff; font-size:7.5px; margin-top:1px;">
                {{ $proverbes[array_rand($proverbes)] }}
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@endsection