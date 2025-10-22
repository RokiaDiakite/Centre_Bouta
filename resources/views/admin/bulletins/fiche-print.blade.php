<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin - {{ $eleve->nom }} {{ $eleve->prenom }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 3mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 6px;
            line-height: 1;
        }

        .content {
            width: 100%;
            padding: 1px;
        }

        h1,
        h4 {
            text-align: center;
            margin: 1px 0;
            padding: 0;
            line-height: 1;
            font-size: 7px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 5.5px;
            margin-top: 1px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 0.5px 1px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        .footer {
            margin-top: 2px;
            display: flex;
            justify-content: space-between;
            font-size: 5.5px;
        }

        .footer div {
            width: 45%;
            text-align: center;
        }

        .info {
            text-align: center;
            margin-bottom: 1px;
            font-size: 5.5px;
        }

        .proverbe {
            text-align: center;
            margin-top: 1px;
            font-style: italic;
            color: #1e90ff;
            font-size: 5.5px;
        }

        .no-print {
            text-align: center;
            margin-top: 1px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="content">
        <h1>Complexe Scolaire Centre Bouta</h1>
        <h4>Bulletin Scolaire</h4>

        <div class="info">
            <p><strong>Année :</strong> {{ $annee->libelle }} | <strong>Évaluation :</strong> {{ $evaluation->nom }}</p>
            <p><strong>Élève :</strong> {{ $eleve->nom }} {{ $eleve->prenom }} | <strong>Sexe :</strong> {{ $eleve->sexe }} | <strong>Classe :</strong> {{ $classe->nom }}</p>
        </div>

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
                @php $totalPondere=0; $sommeCoef=0; @endphp
                @foreach($matieres as $matiere)
                @php
                $note = $notes[$matiere->id] ?? null;
                $coef = $matiere->coefficient ?? 1;
                $devoir = floatval($note->note_devoir ?? 0);
                $evalNote = floatval($note->note_evaluation ?? 0);
                $moyenneMatiere = ($devoir + 2*$evalNote)/3;
                $totalPondere += $moyenneMatiere * $coef;
                $sommeCoef += $coef;
                $appMatiere = $appreciationsMatiere[$matiere->id] ?? '-';
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
                    <th colspan="5">Moyenne Max Classe</th>
                    <th>{{ number_format($moyenneMax,2) }}</th>
                </tr>
                <tr>
                    <th colspan="5">Moyenne Min Classe</th>
                    <th>{{ number_format($moyenneMin,2) }}</th>
                </tr>
                <tr>
                    <th colspan="5">Appréciation</th>
                    <th>{{ $appreciation }}</th>
                </tr>
            </tfoot>
        </table>

        <p><strong>Rang :</strong> {{ $rang }} / {{ $effectifClasse }}</p>

        <div class="footer">
            <div>
                <p><strong>Le Directeur</strong></p>
                <p>______________________</p>
            </div>
            <div>
                <p><strong>Les Parents</strong></p>
                <p>______________________</p>
            </div>
        </div>

        <div class="proverbe">
            <p>{{ $proverbe }}</p>
        </div>
    </div>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary btn-sm">🖨 Imprimer</button>
    </div>
</body>

</html>