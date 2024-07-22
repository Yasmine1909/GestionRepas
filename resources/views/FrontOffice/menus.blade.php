@extends('BackOffice.layouts.app')

@section('content')

<style>
    /* Vos styles ici */
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

    @foreach($weeks as $week)
        @php
            $weekStart = \Carbon\Carbon::parse($week->date_debut);
            $currentDate = \Carbon\Carbon::now();
            $isCurrentWeek = $weekStart->isSameWeek($currentDate);
            $canEdit = !$isCurrentWeek && $weekStart->gt($currentDate->startOfWeek()->addDays(5)); // Seules les semaines après le vendredi de la semaine en cours sont modifiables
        @endphp

        <div class="week-container" data-week-start="{{ $weekStart->format('Y-m-d') }}">
            <div class="week-title">
                Semaine du {{ $weekStart->format('d M Y') }}
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
                                        @if($canEdit)
                                        <a href="{{ url('modifier_menu/' . $plat->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                                        <!-- Formulaire de Suppression -->
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
