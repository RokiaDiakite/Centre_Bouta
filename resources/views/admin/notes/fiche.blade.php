<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Fiche de notes</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /* Fusionne les bordures pour un rendu propre */
            border: 1px solid #000;
            /* Bordure autour du tableau */
        }

        th,
        td {
            border: 1px solid #000;
            /* Bordures de toutes les cellules */
            padding: 4px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }

        /* Assurer que tout s'imprime correctement */
        @media print {
            .no-print {
                display: none;
            }

            table,
            th,
            td {
                border: 1px solid #000 !important;
                /* Force l'affichage des bordures */
                border-collapse: collapse !important;
                /* Fusion des bordures */
            }

            /* Optionnel : pour que le texte et les bordures ressortent mieux à l'impression */
            th,
            td {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

</head>

<body>
    <h1 style="text-align:center;">Complexe Scolaire Centre Bouta</h1>
    <h2 style="text-align:center;">Fiche de notes</h2>
    <p style="text-align:center;">
        Année: {{ $annee->libelle }} | Classe: {{ $classe->nom }} | Matière: {{ $matiere->nom }} | Évaluation: {{ $evaluation->nom }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Élève</th>
                <th>Note devoir</th>
                <th>Note évaluation</th>
                <th>Coefficient</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
            <tr>
                <td>{{ $note->eleve->nom }} {{ $note->eleve->prenom }}</td>
                <td>{{ $note->note_devoir ?? '-' }}</td>
                <td>{{ $note->note_evaluation ?? '-' }}</td>
                <td>{{ $note->matiere->coefficient ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="no-print" style="margin-top:10px; text-align:center;">
        <button onclick="window.print()">🖨 Imprimer</button>
    </div>
</body>

</html>