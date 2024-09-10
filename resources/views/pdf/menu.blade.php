<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Menu de la Semaine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 20px;
        }
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
            margin-bottom: 10px; /* Espacement entre le logo et le texte */
        }
        .header h1 {
            margin: 0;
            text-align: center;
        }
        .info {
            width: 100%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/M2M.jpeg') }}" alt="M2M Logo">
            <h1>Menu de la Semaine du {{ \Carbon\Carbon::parse($week->date_debut)->format('d M Y') }}</h1>
        </div>

        <div class="info">
            <p>Date du Téléchargement: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

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
                            <td>{{ \Carbon\Carbon::parse($week->date_debut)->startOfWeek()->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']))->format('Y-m-d') }}</td>
                            <td>{{ $jour->jour }}</td>
                            <td>{{ $plat->titre }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
