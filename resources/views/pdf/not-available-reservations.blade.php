<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
    <h1>Utilisateurs Non Disponibles</h1>
    <p>Date choisie: {{ $selectedDate }}</p>
    <p>Nombre de Personnes: {{ $totalCount }}</p>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Raison</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->user->last_name }}</td>
                    <td>{{ $reservation->user->email }}</td>
                    <td>{{ $reservation->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
