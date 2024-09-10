<!DOCTYPE html>
<html>
<head>
    <title>Utilisateurs Sans Réponse</title>
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
        .header div {
            display: flex;
            flex-direction: column;
        }
        .header h1 {
            margin: 0;
            text-align: center;
        }
        .info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        p {
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
                <h1>Utilisateurs Sans Réponse</h1>
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
    </div>
</body>
</html>
