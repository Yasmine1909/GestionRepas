@extends('BackOffice.layouts.app')

@section('content')

<style>
    .hide {
        display: none;
    }
    .consultation-only {
        color: grey;
        font-style: italic;
    }
</style>

<div class="container" style="margin-top:15%;">

    <!-- Formulaire de Recherche -->
    <div class="search-bar">
        <form id="searchForm" class="form-inline">
            <input type="date" id="searchDate" class="form-control mr-2" placeholder="Rechercher par date">
            <button type="button" onclick="filterWeeks()" class="btn btn-primary mt-2">Rechercherrr</button>
        </form>
    </div>

    <h1 class="table-title text-center">Tableau de Bord des Menus</h1>
    @foreach($weeks as $week)
    @php
        $weekStart = \Carbon\Carbon::parse($week->date_debut);
        $isConsultationOnly = $weekStart->lt($activeWeeksStart); // Consultation uniquement si la semaine commence avant la semaine active
    @endphp

    <div class="week-container" data-week-start="{{ $weekStart->format('Y-m-d') }}">
        <div class="week-title row">
            <div class="col-6">
                Semaine du {{ $weekStart->format('d M Y') }}
            </div>
            <div class="col-6 mb-2">
                @if(!$isConsultationOnly)
                    <form action="{{ route('dupliquer.semaine', $week->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir dupliquer cette semaine ?');">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Dupliquer</button>
                    </form>
                    <form action="{{ route('supprimer.semaine', $week->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette semaine ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Supprimer la Semaine</button>
                    </form>
                @endif
                <form action="{{ route('telecharger.menu', $week->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">Télécharger Le PDF</button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Date</th>
                        <th>Jour</th>
                        <th>Plat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($week->jours as $jour)
                        @foreach($jour->plats as $plat)
                            <tr>
                                <td>{{ $weekStart->startOfWeek()->addDays(array_search($jour->jour, ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi']))->format('Y-m-d') }}</td>
                                <td>{{ $jour->jour }}</td>
                                <td>{{ $plat->titre }}</td>
                                <td class="actions">
                                    @if(!$isConsultationOnly)
                                        <a href="{{ url('modifier_menu/' . $plat->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                        <form action="{{ route('destroy', $plat->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce plat ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    @else
                                        <span class="consultation-only">Consultation uniquement</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endforeach



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
            const weekStart = week.getAttribute('data-week-start');
            const rows = week.querySelectorAll('tbody tr');
            let hasVisibleRows = false;

            rows.forEach(row => {
                const dateCell = row.getElementsByTagName('td')[0].textContent;
                if (searchDate === '' || dateCell === searchDate || weekStart === searchDate) {
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
