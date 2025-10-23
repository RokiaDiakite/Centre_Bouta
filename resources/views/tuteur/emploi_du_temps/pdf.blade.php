<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Emploi du temps de {{ $eleve->nom }} {{ $eleve->prenom }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .heure-cell {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        small {
            display: block;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <h2>Emploi du temps de {{ $eleve->nom }} {{ $eleve->prenom }}</h2>

    @php
    $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
    $heures = $emplois->map(function($e){
    return $e->heure_debut . ' - ' . $e->heure_fin;
    })->unique()->sort();
    @endphp

    <table>
        <thead>
            <tr>
                <th>Heure / Jour</th>
                @foreach($jours as $jour)
                <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($heures as $heure)
            <tr>
                <td class="heure-cell">{{ $heure }}</td>
                @foreach($jours as $jour)
                @php
                [$debut, $fin] = explode(' - ', $heure);
                $emploiCell = $emplois->where('jour', $jour)
                ->where('heure_debut', $debut)
                ->where('heure_fin', $fin)
                ->first();
                @endphp
                <td>
                    @if($emploiCell)
                    <strong>{{ $emploiCell->matiere->nom }}</strong>
                    <small>{{ $emploiCell->maitre->nom }} {{ $emploiCell->maitre->prenom }}</small>
                    @else
                    -
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>