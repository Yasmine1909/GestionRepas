@extends('BackOffice.layouts.app')

@section('content')

<div class="container" style="margin-bottom:10%;margin-top:10%;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center text-secondary mb-4">Paramétrer les Menus de la Semaine</h1>

            {{-- Affichage des messages --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('store') }}" method="post" class="form-group">
                @csrf

                <div class="mb-4">
                    <label for="week_start" class="form-label">Choisissez la Semaine</label>
                    <input type="week" class="form-control" id="week_start" name="week_start" required>
                </div>

                <div class="mb-4">
                    <label for="active_days" class="form-label">Sélectionnez les Jours Actifs</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="Lundi" name="active_days[]" value="Lundi">
                        <label class="form-check-label" for="Lundi">Lundi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="Mardi" name="active_days[]" value="Mardi">
                        <label class="form-check-label" for="Mardi">Mardi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="Mercredi" name="active_days[]" value="Mercredi">
                        <label class="form-check-label" for="Mercredi">Mercredi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="Jeudi" name="active_days[]" value="Jeudi">
                        <label class="form-check-label" for="Jeudi">Jeudi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="Vendredi" name="active_days[]" value="Vendredi">
                        <label class="form-check-label" for="Vendredi">Vendredi</label>
                    </div>
                </div>

                <div id="menus" class="mb-4">
                    {{-- Sections for each active day will be dynamically added here --}}
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-block" style="background-color: #ffb03b;">Enregistrer les Menus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', () => {
    const activeDaysCheckboxes = document.querySelectorAll('input[name="active_days[]"]');
    const menusContainer = document.getElementById('menus');
    const currentFriday = new Date('{{ $currentFriday }}');
    const currentDate = new Date('{{ $currentDate }}');

    // Désactiver les dates avant le vendredi de la semaine en cours
    const weekInput = document.getElementById('week_start');
    weekInput.addEventListener('input', () => {
        const selectedWeek = weekInput.value;
        const [year, week] = selectedWeek.split('-W');
        const selectedDate = new Date(year, 0, (week - 1) * 7);
        const selectedFriday = new Date(selectedDate);
        selectedFriday.setDate(selectedDate.getDate() + 4); // Obtenir le vendredi de la semaine sélectionnée

        if (selectedFriday <= currentFriday || selectedDate <= currentDate) {
            weekInput.setCustomValidity('La semaine sélectionnée doit être après le vendredi de la semaine en cours.');
            weekInput.reportValidity();
        } else {
            weekInput.setCustomValidity('');
        }
    });

    activeDaysCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            // Remove all existing menu sections
            while (menusContainer.firstChild) {
                menusContainer.removeChild(menusContainer.firstChild);
            }

            activeDaysCheckboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const day = checkbox.nextElementSibling.textContent;
                    const section = document.createElement('div');
                    section.classList.add('mb-4');
                    section.innerHTML = `
                        <h4 class="text-center text-secondary mb-4">${day}</h4>
                        <div class="mb-3">
                            <label for="plat_title_${day}" class="form-label">Plat pour ${day}</label>
                            <input type="text" class="form-control" id="plat_title_${day}" name="plat_title_${day}" placeholder="Titre du Plat">
                        </div>
                    `;
                    menusContainer.appendChild(section);
                }
            });
        });
    });
});
</script>

@endsection
