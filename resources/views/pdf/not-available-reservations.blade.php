<!DOCTYPE html>
<html>
<head>
    <title>Utilisateurs Non Disponibles</title>
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
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
            margin-right: 20px; /* Espacement entre le logo et le texte */
        }
        .header h1 {
            margin: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        p {
            /* text-align: center; */
            margin-right: 20px; /* Espacement entre le logo et le texte */
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/M2M.jpeg') }}" alt="M2M Logo">
            <div>
                <h1>Utilisateurs Non Disponibles</h1>
                <div class="info">
                    <p>Date choisie: {{ $selectedDate }}</p>
                    <p>Date du Téléchargement: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
                </div>
                <p>Nombre de Personnes: {{ $totalCount }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Raison</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->user->email }}</td>
                        <td>{{ $reservation->reason }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
