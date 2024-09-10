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
        .header h2 {
            margin: 0;
            text-align: center;
        }
        .info {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
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
            <h2>Menu de la Semaine du {{ \Carbon\Carbon::parse($semaine->date_debut)->format('d/m/Y') }}</h2>
        </div>

        <div class="info">
            <p>Date du Téléchargement: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Plat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($semaine->jours as $jour)
                    <tr>
                        <td>{{ ucfirst($jour->jour) }}</td>
                        <td>
                            @foreach($jour->plats as $plat)
                                {{ $plat->titre }}<br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
