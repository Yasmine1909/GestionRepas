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
            <button class="btn btn-primary btn-block" id="fetchStatsBtn">Afficher les Statistiques</button>
        </div>
    </div>

    <!-- Statistiques globales -->
    <div class="row">
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Réservations Confirmées</h5>
                <span id="totalConfirmedReservations" class="display-4">0</span>
                <button class="btn btn-success btn-block mb-2" id="downloadConfirmedList">Télécharger la Liste en PDF</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Non Disponibles</h5>
                <span id="totalNotAvailableReservations" class="display-4">0</span>
                <button class="btn btn-warning btn-block mb-2" id="downloadNotAvailableList">Télécharger la Liste en PDF</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <h5>Pas Encore Répondu</h5>
                <span id="totalNoResponseReservations" class="display-4">0</span>
                <button class="btn btn-danger btn-block mb-2" id="downloadNoResponseList">Télécharger la Liste en PDF</button>
            </div>
        </div>
    </div>

    <!-- Listes détaillées avec boutons de téléchargement -->
    <div class="row mt-4">
        <div class="col-md-4">
            <ul class="list-group" id="confirmedList" style="display: none;">
                <!-- Liste dynamique -->
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group" id="notAvailableList" style="display: none;">
                <!-- Liste dynamique -->
            </ul>
        </div>
        <div class="col-md-4">
            <ul class="list-group" id="noResponseList" style="display: none;">
                <!-- Liste dynamique -->
            </ul>
        </div>
    </div>

    <!-- Tableau des semaines avec bouton de téléchargement PDF -->
    <div class="row mt-4">
        <div class="col-md-12">
            <h2 class="text-center mb-4">Historique des Semaines</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Semaine du:</th>
                        <th>Télécharger le PDF</th>
                    </tr>
                </thead>
                <tbody id="weeksTableBody">
                    <!-- Les lignes de tableau seront ajoutées dynamiquement ici -->
                </tbody>
            </table>
            <nav>
                <ul class="pagination" id="pagination" style="justify-content: center;">
                    <!-- Pagination sera ajoutée dynamiquement ici -->
                </ul>
            </nav>
        </div>
    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
$(document).ready(function() {
    $('#fetchStatsBtn').click(function() {
        const selectedDate = $('#selectedDate').val();

        $.ajax({
            url: '/reservation-stats/fetch',
            method: 'POST',
            data: {
                date: selectedDate,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                $('#totalConfirmedReservations').text(data.confirmedList.length);
                $('#totalNotAvailableReservations').text(data.notAvailableList.length);
                $('#totalNoResponseReservations').text(data.noResponseList.length);

                updateList('confirmedList', data.confirmedList);
                updateList('notAvailableList', data.notAvailableList);
                updateList('noResponseList', data.noResponseList);
            }
        });
    });

    $('#downloadConfirmedList').click(function() {
        const selectedDate = $('#selectedDate').val();
        downloadList('confirmedList', 'Réservations Confirmées', selectedDate);
    });

    $('#downloadNotAvailableList').click(function() {
        const selectedDate = $('#selectedDate').val();
        downloadList('notAvailableList', 'Utilisateurs Non Disponibles', selectedDate);
    });

    $('#downloadNoResponseList').click(function() {
        const selectedDate = $('#selectedDate').val();
        downloadList('noResponseList', 'Pas Encore Répondu', selectedDate);
    });

    function updateList(listId, items) {
        const list = $('#' + listId);
        list.empty();

        items.forEach(item => {
            const statusClass = item.status === 'Confirmé' ? 'success' : item.status === 'Non Disponible' ? 'danger' : 'warning';
            const reasonText = item.reason ? ` - Raison: ${item.reason}` : ''; // Texte de la raison s'il existe
            list.append(`
                <li class="list-group-item" data-email="${item.email}" data-reason="${item.reason}">
                    ${item.name} ${item.last_name} - ${item.email}${reasonText}
                    <span class="badge badge-${statusClass}">${item.status}</span>
                </li>
            `);
        });
    }

    function downloadList(listId, title, selectedDate) {
        const list = document.getElementById(listId);
        const items = list.getElementsByTagName('li');

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const margins = { top: 20, left: 15, bottom: 15 };
        const lineHeight = 10;

        // Date actuelle
        const currentDate = new Date().toLocaleDateString();

        // Titre du document
        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.text(title, margins.left, margins.top);

        // Information de la date sélectionnée et la date de téléchargement
        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        doc.text(`Nombre de Personnes Dans cette Liste: ${items.length}`, margins.left, margins.top + 10);
        doc.text(`Date choisie: ${selectedDate}`, margins.left, margins.top + 20);
        doc.text(`Téléchargé le: ${currentDate}`, margins.left, margins.top + 30);

        let y = margins.top + 40;

        doc.setFont("helvetica", "normal");
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const email = item.getAttribute('data-email');
            const name = item.textContent.trim().split(/\s+/);
            const status = item.querySelector('.badge').textContent.trim(); // Trim pour éviter les erreurs d'espace
            const reason = item.getAttribute('data-reason'); // Récupération de la raison

            // Affichage des données : Nom, Prénom, Email
            doc.text(`${name[0]} ${name[1]} - ${email}`, margins.left, y);

            // Si le statut est 'Non Disponible', ajouter la raison
            if (status === 'Non Disponible' && reason) {
                y += lineHeight;
                doc.text(`Raison: ${reason}`, margins.left, y);
            }

            y += lineHeight;

            // Si la page est pleine, ajouter une nouvelle page
            if (y > doc.internal.pageSize.height - margins.bottom) {
                doc.addPage();
                y = margins.top;
            }
        }

        doc.save(`${listId}.pdf`);
    }

    let currentPage = 1;

function loadWeeks(page = 1) {
    $.ajax({
        url: '/reservation-stats/history',
        method: 'GET',
        data: { page: page },
        success: function(response) {
            const tableBody = $('#weeksTableBody');
            const pagination = $('#pagination');
            tableBody.empty();
            pagination.empty();

            // Ajouter les semaines au tableau
            response.data.forEach(week => {
                tableBody.append(`
                    <tr>
                        <td>${week.date_debut}</td>
                        <td><a href="/download-week-pdf/${week.id}" class="btn btn-primary btn-sm">Télécharger</a></td>
                    </tr>
                `);
            });

            // Ajouter la pagination
            if (response.last_page > 1) {
                // Page précédente
                if (response.current_page > 1) {
                    pagination.append(`
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${response.current_page - 1}">&laquo; Précédent</a>
                        </li>
                    `);
                }

                // Pages numérotées
                for (let i = 1; i <= response.last_page; i++) {
                    const activeClass = i === response.current_page ? 'active' : '';
                    pagination.append(`
                        <li class="page-item ${activeClass}">
                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                        </li>
                    `);
                }

                // Page suivante
                if (response.current_page < response.last_page) {
                    pagination.append(`
                        <li class="page-item">
                            <a class="page-link" href="#" data-page="${response.current_page + 1}">Suivant &raquo;</a>
                        </li>
                    `);
                }
            }
        }
    });
}


    loadWeeks();
    // Gestion des clics sur les boutons de pagination
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            currentPage = page;
            loadWeeks(page);
        }
    });
});
</script>
@endsection
