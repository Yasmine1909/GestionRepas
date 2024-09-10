<!DOCTYPE html>
<html>
<head>
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
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
            margin-right: 20px;
        }
        .week-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .day-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .day-table th, .day-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .day-table th {
            background-color: #f4f4f4;
        }
        .day-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .day-table td {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/M2M.jpeg') }}" alt="M2M Logo" style="height: 100px;">
        </div>

        <h1>Réservations De La Semaine</h1>

        <div class="week-info">
            <p>Semaine du {{ \Carbon\Carbon::parse($week->date_debut)->format('d/m/Y') }}</p>
            <p>Date du Téléchargement: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <table class="day-table">
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Menu</th>
                    <th>Nombre de Réservations Disponibles</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($week->jours as $jour)
                    <tr>
                        <td>{{ $jour->jour }} ({{ \Carbon\Carbon::parse($jour->date)->format('d/m/Y') }})</td>
                        <td>
                            @foreach ($jour->plats as $plat)
                                <strong>{{ $plat->titre }}</strong><br>
                            @endforeach
                        </td>
                        <td>
                            @php
                                $availableReservationsCount = $jour->plats->flatMap(function ($plat) {
                                    return $plat->reservations->where('status', 'available');
                                })->count();
                            @endphp
                            {{ $availableReservationsCount }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
