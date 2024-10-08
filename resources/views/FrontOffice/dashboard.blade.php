@extends('FrontOffice/layouts.app')

@section('content')

<style>
    .calendar {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: 1px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        max-width: 800px; /* Adjust the width as needed */
        margin: auto;
    }
    .calendar div {
        padding: 10px;
        text-align: center;
        border: 1px solid #dee2e6;
        background-color: #ffffff;
    }
    .calendar .header {
        background-color: #007bff;
        color: #ffffff;
        font-weight: bold;
    }
    .calendar .weekend {
        background-color: #e9ecef;
    }
    .calendar .disabled {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    .calendar .clickable {
        cursor: pointer;
    }
    .calendar .clickable:hover {
        background-color: #e0a800;
        color: #ffffff;
    }
    .calendar .available {
        background-color: #007bff;
        color: #ffffff;
    }
    .calendar .available:hover {
        background-color: #0056b3;
    }
    .calendar .reserved {
        background-color: #dc3545;
        color: #ffffff;
    }
    .calendar .reserved:hover {
        background-color: #c82333;
    }
    .calendar .download {
        background-color: #28a745;
        color: #ffffff;
        cursor: pointer;
        text-align: center;
    }
    .calendar .download:hover {
        background-color: #218838;
    }
    .modal-body {
        padding: 1rem;
    }
</style>

<div class="container" style="margin-top: 10%; margin-bottom: 5%;">
    <h1 class="text-center mb-4">Réservations de Repas</h1>
    <div class="calendar">
        <!-- Headers for days of the week and download buttons -->
        <div class="header">Lun</div>
        <div class="header">Mar</div>
        <div class="header">Mer</div>
        <div class="header">Jeu</div>
        <div class="header">Ven</div>
        <div class="header">Sam</div>
        <div class="header">Dim</div>
        <div class="header">Télécharger</div>

        <!-- Example static days for July 2024 -->
        <div class="disabled">01</div>
        <div class="disabled">02</div>
        <div class="disabled">03</div>
        <div class="disabled">04</div>
        <div class="disabled">05</div>
        <div class="weekend">06</div>
        <div class="weekend">07</div>
        <div class="download"><button class="btn btn-success download">Télécharger le Menu</button></div>

        <div class="clickable">08</div>
        <div class="clickable">09</div>
        <div class="clickable">10</div>
        <div class="clickable">11</div>
        <div class="clickable">12</div>
        <div class="weekend">13</div>
        <div class="weekend">14</div>
        <div class="download"><button class="btn btn-success download">Télécharger le Menu</button></div>

        <div class="clickable">15</div>
        <div class="clickable">16</div>
        <div class="clickable">17</div>
        <div class="clickable">18</div>
        <div class="clickable">19</div>
        <div class="weekend">20</div>
        <div class="weekend">21</div>
        <div class="download"><button class="btn btn-success download">Télécharger le Menu</button></div>

        <div class="clickable available">22</div>
        <div class="clickable available">23</div>
        <div class="clickable reserved" data-toggle="modal" data-target="#menuModal">24</div>
        <div class="clickable available">25</div>
        <div class="clickable available">26</div>
        <div class="weekend">27</div>
        <div class="weekend">28</div>
        <div class="download"><button class="btn btn-success download">Télécharger le Menu</button></div>

        <div class="clickable available">29</div>
        <div class="clickable available">30</div>
        <div class="clickable available">31</div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div class="download"><button class="btn btn-success download">Télécharger le Menu</button></div>
    </div>
</div>

<!-- Modal for displaying menu -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">Menu du Jour</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Date:</strong> <span id="menuDate">24-07-2024</span></p>
                <p><strong>Plat Principal:</strong> Coq au Vin</p>
                <div id="reasonContainer" class="mb-3" style="display: none;">
                    <label for="reason" class="form-label">Motif de Non Disponibilité</label>
                    <select class="form-control" id="reason" name="reason">
                        <option value="deplacement">Déplacement</option>
                        <option value="conge">Congé</option>
                        <option value="regime">Régime</option>
                    </select>
                </div>
                <div id="availabilityContainer" class="mb-3">
                    <label for="availability" class="form-label">Disponibilité</label>
                    <select class="form-control" id="availability" name="availability">
                        <option value="yes">Disponible</option>
                        <option value="no">Non Disponible</option>
                    </select>
                </div>
                <p><strong>Status:</strong> <span id="reservationStatus">Réservé</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" id="reserveButton" style="display: none;">Réserver</button>
                <button type="button" class="btn btn-success" id="validateButton" style="display: none;">Valider</button>
                <button type="button" class="btn btn-danger" id="cancelButton" style="display: none;">Annuler Réservation</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cells = document.querySelectorAll('.calendar .clickable');
    const availabilitySelect = document.getElementById('availability');
    const reasonContainer = document.getElementById('reasonContainer');
    const availabilityContainer = document.getElementById('availabilityContainer');

    cells.forEach(cell => {
        cell.addEventListener('click', () => {
            const date = cell.textContent;
            const isReserved = cell.classList.contains('reserved');
            const isAvailable = cell.classList.contains('available');

            document.getElementById('menuDate').textContent = `2024-07-${date.padStart(2, '0')}`;
            document.getElementById('reservationStatus').textContent = isReserved ? 'Réservé' : isAvailable ? 'Réservable' : 'Non Réservable';
            document.getElementById('reserveButton').style.display = isReserved ? 'none' : 'block';
            document.getElementById('validateButton').style.display = 'none';
            document.getElementById('cancelButton').style.display = isReserved ? 'block' : 'none';

            if (isReserved) {
                availabilityContainer.style.display = 'none';
                reasonContainer.style.display = 'none';
                document.getElementById('validateButton').style.display = 'none';
            } else {
                availabilityContainer.style.display = 'block';
                availabilitySelect.addEventListener('change', () => {
                    if (availabilitySelect.value === 'no') {
                        reasonContainer.style.display = 'block';
                        document.getElementById('reserveButton').style.display = 'none';
                        document.getElementById('validateButton').style.display = 'block';
                    } else {
                        reasonContainer.style.display = 'none';
                        document.getElementById('reserveButton').style.display = 'block';
                        document.getElementById('validateButton').style.display = 'none';
                    }
                });
            }

            $('#menuModal').modal('show');
        });
    });

    const downloadButtons = document.querySelectorAll('.download button');
    downloadButtons.forEach(button => {
        button.addEventListener('click', () => {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text("Menu de la Semaine", 10, 10);
            doc.text("Lundi: Coq au Vin", 10, 20);
            doc.text("Mardi: Poulet Rôti", 10, 30);
            doc.text("Mercredi: Ratatouille", 10, 40);
            doc.text("Jeudi: Steak Frites", 10, 50);
            doc.text("Vendredi: Saumon Grillé", 10, 60);

            doc.save("Menu_Semaine.pdf");
        });
    });
});
</script>

@endsection
