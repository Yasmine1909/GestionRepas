@extends('BackOffice.layouts.app')

@section('content')
<style>
    .stat-card {
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: center;
    }
    .stat-card h5 {
        margin-bottom: 15px;
    }
    .list-group-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .table th, .table td {
        text-align: center;
    }
</style>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container" style="margin-top: 50px;">
    <h1 class="text-center mb-4">Statistiques des Réservations</h1>

    <!-- Section pour la sélection de la date -->
    <div class="row mb-4">
        <div class="col-md-6 offset-md-3">
            <input type="date" class="form-control" id="selectedDate" placeholder="Sélectionnez une date">
        </div>
        <div class="col-md-6 offset-md-3 mt-3">
            <button class="btn btn-primary btn-block" onclick="fetchStats()">Afficher les Statistiques</button>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="row">
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Total des Utilisateurs</h5>
                <span id="totalUsers" class="display-4">0</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Réservations Confirmées</h5>
                <span id="confirmedReservations" class="display-4">0</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Utilisateurs Non Disponibles</h5>
                <span id="notAvailableUsers" class="display-4">0</span>
            </div>
        </div>
    </div>

    <!-- Listes détaillées avec boutons de téléchargement -->
    <div class="row mt-4">
        <div class="col-md-4">
            <h5 class="text-center">Réservations Confirmées</h5>
            <button class="btn btn-success btn-block mb-2" onclick="downloadList('confirmedList')">Télécharger la Liste</button>
            <ul class="list-group" id="confirmedList">
                <!-- Liste dynamique -->
            </ul>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Utilisateurs Non Disponibles</h5>
            <button class="btn btn-danger btn-block mb-2" onclick="downloadList('notAvailableList')">Télécharger la Liste</button>
            <ul class="list-group" id="notAvailableList">
                <!-- Liste dynamique -->
            </ul>
        </div>
        <div class="col-md-4">
            <h5 class="text-center">Pas Encore Répondu</h5>
            <button class="btn btn-warning btn-block mb-2" onclick="downloadList('noResponseList')">Télécharger la Liste</button>
            <ul class="list-group" id="noResponseList">
                <!-- Liste dynamique -->
            </ul>
        </div>
    </div>

    <!-- Dashboard pour les dates passées -->
    <div class="mt-5">
        <h2 class="text-center mb-4">Historique des Statistiques</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Confirmés</th>
                        <th>Non Disponibles</th>
                        {{-- <th>Pas Encore Répondu</th> --}}
                    </tr>
                </thead>
                <tbody id="historyTable">
                    <!-- Historique dynamique à ajouter -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    function fetchStats() {
        const selectedDate = document.getElementById('selectedDate').value;

        $.ajax({
            url: '/reservation-stats/fetch',
            method: 'POST',
            data: {
                date: selectedDate,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                document.getElementById('totalUsers').innerText = data.totalUsers;
                document.getElementById('confirmedReservations').innerText = data.confirmedList.length;
                document.getElementById('notAvailableUsers').innerText = data.notAvailableList.length;

                updateList('confirmedList', data.confirmedList);
                updateList('notAvailableList', data.notAvailableList);
                updateList('noResponseList', data.noResponseList);
            }
        });
    }

    function updateList(listId, items) {
        const list = document.getElementById(listId);
        list.innerHTML = '';

        items.forEach(item => {
            const li = document.createElement('li');
            li.classList.add('list-group-item');
            li.innerHTML = `${item.name} <span class="badge badge-${item.status === 'Confirmé' ? 'success' : item.status === 'Non Disponible' ? 'danger' : 'warning'}">${item.status}</span>`;
            list.appendChild(li);
        });
    }

    function downloadList(listId) {
        const list = document.getElementById(listId);
        const items = list.getElementsByTagName('li');
        let content = '';

        for (let item of items) {
            content += item.textContent.trim() + '\n';
        }

        const blob = new Blob([content], { type: 'text/plain' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `${listId}.txt`;
        a.click();
        URL.revokeObjectURL(url);
    }

    function fetchHistory() {
        $.ajax({
            url: '/reservation-stats/fetch-history',
            method: 'GET',
            success: function(data) {
                const tableBody = document.getElementById('historyTable');
                tableBody.innerHTML = '';

                data.forEach(record => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${record.date}</td>
                        <td>${record.confirmed}</td>
                        <td>${record.not_available}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                }
            });
        }

        // <td>${record.no_response}</td> si tu veux ajouter pas de reponse
    // Appeler fetchHistory au chargement de la page pour afficher l'historique
    document.addEventListener('DOMContentLoaded', fetchHistory);
</script>

@endsection
