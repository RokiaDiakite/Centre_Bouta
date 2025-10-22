<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du temps - Maitre {{ $maitre->nom }} {{ $maitre->prenom }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid black; padding: 6px; text-align: center; }
        th { background-color: #b0c4de; color: #000; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Emploi du temps - Maitre {{ $maitre->nom }} {{ $maitre->prenom }}</h2>

    @php
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $heures = $emplois->pluck('heure_debut')->sort()->unique();
    @endphp

    <table>
        <thead>
            <tr>
                <th>Heures</th>
                @foreach($jours as $jour)
                    <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($heures as $heure)
            <tr>
                <td>{{ $heure }}</td>
                @foreach($jours as $jour)
                    @php
                        $cours = $emplois->first(function($e) use ($jour, $heure) {
                            return $e->jour == $jour && $e->heure_debut == $heure;
                        });
                    @endphp
                    <td>
                        @if($cours)
                            <strong>{{ $cours->matiere->nom }}</strong><br>
                            {{ $cours->classe->nom }}
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
