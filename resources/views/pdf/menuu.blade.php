<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Menu de la semaine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #dddddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Menu de la semaine du {{ $semaine->date_debut }}</h2>
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
</body>
</html>
