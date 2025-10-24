<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Emploi du Temps - {{ $maitre->nom }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Emploi du Temps de {{ $maitre->nom }}</h2>
    <table>
        <thead>
            <tr>
                <th>Jour</th>
                <th>Heure Début</th>
                <th>Heure Fin</th>
                <th>Classe</th>
                <th>Matière</th>
                <th>Année Scolaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($emplois as $emploi)
            <tr>
                <td>{{ ucfirst($emploi->jour) }}</td>
                <td>{{ \Carbon\Carbon::parse($emploi->heure_debut)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($emploi->heure_fin)->format('H:i') }}</td>
                <td>{{ $emploi->classe->nom }}</td>
                <td>{{ $emploi->matiere->nom }}</td>
                <td>{{ $emploi->anneeScolaire->libelle ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>