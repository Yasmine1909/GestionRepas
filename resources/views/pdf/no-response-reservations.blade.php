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
    <h1>Utilisateurs Sans Réponse</h1>
    <p>Date choisie: {{ $selectedDate }}</p>
    <p>Nombre de Personnes: {{ $totalCount }}</p>
    <table>
        <thead>
            <tr>
                <th>Nom Complet</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
