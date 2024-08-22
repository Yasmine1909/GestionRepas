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
                <h5> Réservations Confirmées</h5>
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
            downloadList('confirmedList', 'Réservations Confirmées');
        });

        $('#downloadNotAvailableList').click(function() {
            downloadList('notAvailableList', 'Utilisateurs Non Disponibles');
        });

        $('#downloadNoResponseList').click(function() {
            downloadList('noResponseList', 'Pas Encore Répondu');
        });

        function updateList(listId, items) {
            const list = $('#' + listId);
            list.empty();

            items.forEach(item => {
                // Affichage en HTML avec les données dans les attributs data-*
                const statusClass = item.status === 'Confirmé' ? 'success' : item.status === 'Non Disponible' ? 'danger' : 'warning';
                list.append(`
                    <li class="list-group-item" data-email="${item.email}">
                        ${item.name} ${item.last_name}
                        <span class="badge badge-${statusClass}">${item.status}</span>
                    </li>
                `);
            });
        }

        function downloadList(listId, title) {
        const list = document.getElementById(listId);
        const items = list.getElementsByTagName('li');

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const margins = { top: 20, left: 15, bottom: 15 };
        const lineHeight = 10;
        const pageWidth = 210;
        const columnWidths = [30, 60, 80]; // Largeur des colonnes : Prénom, Nom, Email

        doc.setFontSize(16);
        doc.setFont("helvetica", "bold");
        doc.text(title, margins.left, margins.top);

        doc.setFontSize(12);
        doc.setFont("helvetica", "normal");
        doc.text(`Nombre de Personnes Dans cette Liste: ${items.length}`, margins.left, margins.top + 10);
        doc.text(`Date: ${new Date().toLocaleDateString()}`, margins.left, margins.top + 20);

        let y = margins.top + 30;
        doc.setFont("helvetica", "bold");

        // Dessin des en-têtes avec cadres
        doc.text('Prénom', margins.left, y);
        doc.text('Nom', margins.left + columnWidths[0], y);
        doc.text('Email', margins.left + columnWidths[0] + columnWidths[1], y);

        // Dessin des cadres pour les en-têtes
        doc.rect(margins.left - 1, y - 10, columnWidths[0] + columnWidths[1] + columnWidths[2] + 2, 10); // Cadre autour des en-têtes
        doc.rect(margins.left - 1, y, columnWidths[0], lineHeight); // Cadre pour 'Prénom'
        doc.rect(margins.left + columnWidths[0] - 1, y, columnWidths[1], lineHeight); // Cadre pour 'Nom'
        doc.rect(margins.left + columnWidths[0] + columnWidths[1] - 1, y, columnWidths[2], lineHeight); // Cadre pour 'Email'

        y += lineHeight;

        doc.setFont("helvetica", "normal");
        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const email = item.getAttribute('data-email');
            const name = item.textContent.trim().split(/\s+/);

            doc.text(name[0], margins.left, y);
            doc.text(name[1], margins.left + columnWidths[0], y);
            doc.text(email, margins.left + columnWidths[0] + columnWidths[1], y);

            // Dessin des cadres pour les lignes de données
            doc.rect(margins.left - 1, y - 5, columnWidths[0] + columnWidths[1] + columnWidths[2] + 2, lineHeight); // Cadre autour de chaque ligne
            y += lineHeight;
        }

        doc.save(`${listId}.pdf`);
    }










    });
</script>

@endsection
