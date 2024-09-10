<!DOCTYPE html>
<html>
<head>
    <title>Réservations Confirmées</title>
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
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
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
            <h1>Réservations Confirmées</h1>
            <div class="info">
                <p>Date choisie: {{ $date }}</p>
                <p>Nombre de Personnes: {{ $reservations->count() }}</p>
                <p>Date du Téléchargement: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->user->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
