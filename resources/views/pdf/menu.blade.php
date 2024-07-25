<!DOCTYPE html>
<html>
<head>
    <title>Menu de la Semaine</title>
    <style>
        /* Ajoutez ici les styles pour le PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Menu de la Semaine du {{ $week->date_debut->format('d M Y') }}</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Jour</th>
                <th>Plat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($week->jours as $jour)
                @foreach($jour->plats as $plat)
                    <tr>
                        <td>{{ $week->date_debut->copy()->startOfWeek()->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']))->format('Y-m-d') }}</td>
                        <td>{{ $jour->jour }}</td>
                        <td>{{ $plat->titre }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
