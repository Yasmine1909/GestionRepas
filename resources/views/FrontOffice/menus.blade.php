@extends('BackOffice/layouts.app')

@section('content')

    <style>
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .table {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        thead {
            background-color: #f8f9fa;
        }
        thead th {
            color: #495057;
            font-weight: 600;
        }
        tbody td {
            vertical-align: middle;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .container {
            margin-top: 5%;
        }
        .table-title {
            background-color: #35322d;
            color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        .consultation-only {
            color: #6c757d;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .week-container {
            margin-bottom: 3rem;
        }
        .week-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #007bff;
        }
        .search-bar {
            margin-bottom: 2rem;
        }
        .hide {
            display: none;
        }
    </style>

    <div class="container" style="margin-top:15%;">

        <!-- Formulaire de Recherche -->
        <div class="search-bar">
            <form id="searchForm" class="form-inline">
                <input type="date" id="searchDate" class="form-control mr-2" placeholder="Rechercher par date">
                <button type="button" onclick="filterWeeks()" class="btn btn-primary mt-2">Rechercher</button>
            </form>
        </div>

        <h1 class="table-title text-center">Tableau de Bord des Menus</h1>

        <!-- Menus -->
        <div id="week22" class="week-container">
            <div class="week-title">Semaine du 22 Juillet 2024</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Entrée</th>
                            <th>Plat Principal</th>
                            <th>Dessert</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-07-22</td>
                            <td>Salade César</td>
                            <td>Steak Frites</td>
                            <td>Tarte au Citron</td>
                            <td class="actions">
                                <a href="modifier_menu" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="#" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2024-07-23</td>
                            <td>Soupe de légumes</td>
                            <td>Poulet rôti</td>
                            <td>Crème Caramel</td>
                            <td class="actions">
                                <a href="#" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="#" class="btn btn-danger btn-sm">Supprimer</a>
                            </td>
                        </tr>
                        <!-- Ajoutez plus de lignes pour la semaine du 22 Juillet -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="week15" class="week-container">
            <div class="week-title">Semaine du 15 Juillet 2024</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Entrée</th>
                            <th>Plat Principal</th>
                            <th>Dessert</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-07-15</td>
                            <td>Soupe à l'Oignon</td>
                            <td>Coq au Vin</td>
                            <td>Mousse au Chocolat</td>
                            <td class="consultation-only">Consultation uniquement</td>
                        </tr>
                        <tr>
                            <td>2024-07-16</td>
                            <td>Salade de tomates</td>
                            <td>Steak Haché</td>
                            <td>Tarte aux Pommes</td>
                            <td class="consultation-only">Consultation uniquement</td>
                        </tr>
                        <!-- Ajoutez plus de lignes pour la semaine du 15 Juillet -->
                    </tbody>
                </table>
            </div>
        </div>

        <div id="week08" class="week-container">
            <div class="week-title">Semaine du 8 Juillet 2024</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Date</th>
                            <th>Entrée</th>
                            <th>Plat Principal</th>
                            <th>Dessert</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2024-07-08</td>
                            <td>Quiche Lorraine</td>
                            <td>Bouef Bourguignon</td>
                            <td>Crème Brûlée</td>
                            <td class="consultation-only">Consultation uniquement</td>
                        </tr>
                        <tr>
                            <td>2024-07-09</td>
                            <td>Salade de chèvre</td>
                            <td>Coq au vin</td>
                            <td>Macarons</td>
                            <td class="consultation-only">Consultation uniquement</td>
                        </tr>
                        <!-- Ajoutez plus de lignes pour la semaine du 8 Juillet -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function filterWeeks() {
            const searchDate = document.getElementById('searchDate').value;
            const weeks = document.querySelectorAll('.week-container');

            weeks.forEach(week => {
                const rows = week.querySelectorAll('tbody tr');
                let hasVisibleRows = false;

                rows.forEach(row => {
                    const dateCell = row.getElementsByTagName('td')[0].textContent;
                    if (searchDate === '' || dateCell === searchDate) {
                        row.classList.remove('hide');
                        hasVisibleRows = true;
                    } else {
                        row.classList.add('hide');
                    }
                });

                if (hasVisibleRows) {
                    week.classList.remove('hide');
                } else {
                    week.classList.add('hide');
                }
            });
        }
    </script>
@endsection
