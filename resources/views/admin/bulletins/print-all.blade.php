<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletins - {{ $classe->nom }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 0;
        }

        @page {
            size: A4 landscape;
            margin: 5mm;
        }

        /* Container pour tous les bulletins */
        .bulletin-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .eleve {
            width: calc(50% - 5mm);
            /* demi page - espace pour découpe */
            display: inline-block;
            vertical-align: top;
            box-sizing: border-box;
            padding: 3mm;
            margin-bottom: 5mm;
            /* petit espace vertical */
            page-break-inside: avoid;
            border: 1px dashed transparent;
            /* pour voir le découpage si nécessaire */
        }

        h4 {
            text-align: center;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3px;
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 2px 3px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 9px;
        }

        .proverbe {
            text-align: center;
            font-style: italic;
            color: #1e90ff;
            font-size: 9px;
            margin-top: 2px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="no-print" style="text-align:center; margin-bottom:5px;">
        <button onclick="window.print()" class="btn btn-primary btn-sm">🖨 Imprimer tous les bulletins</button>
        <button><a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">⬅ Retour</a></button>
    </div>

    <div class="bulletin-container">
        @foreach($eleves as $eleve)
        @php
        $notesEleve = $notes[$eleve->id] ?? [];
        $totalPondere = 0;
        $sommeCoef = 0;
        @endphp

        <div class="eleve">
            <h1>Complexe Scolaire Centre Bouta</h1>
            <h4>Bulletin Scolaire</h4>
            <h4>{{ $eleve->nom }} {{ $eleve->prenom }} - {{ $classe->nom }}</h4>
            <p style="text-align:center; font-size:8px; margin:2px 0;">
                Année: {{ $annee->libelle }} | Évaluation: {{ $evaluation->nom }} | Sexe: {{ $eleve->sexe }}
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Matières</th>
                        <th>Dévoir</th>
                        <th>Composition</th>
                        <th>Coef</th>
                        <th>Moyenne</th>
                        <th>Appréciation</th>
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
                        <th colspan="5">Moyenne Générale</th>
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

            <div class="footer">
                <div>Le Directeur<br>________________</div>
                <div>Les Parents<br>________________</div>
            </div>

            <div class="proverbe">
                {{ $proverbes[array_rand($proverbes)] }}
            </div>
        </div>
        @endforeach
    </div>

</body>

</html>