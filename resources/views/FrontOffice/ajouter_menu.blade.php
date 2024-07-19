@extends('BackOffice/layouts.app')

@section('content')

<div class="container" style="margin-bottom:10%;margin-top:10%;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center text-secondary mb-4">Paramétrer les Menus de la Semaine</h1>
            <form action="" method="post" class="form-group">
                @csrf

                <div class="mb-4">
                    <label for="week_start" class="form-label">Choisissez la Semaine</label>
                    <input type="week" class="form-control" id="week_start" name="week_start" required>
                </div>

                <div class="mb-4">
                    <label for="active_days" class="form-label">Sélectionnez les Jours Actifs</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="monday" name="active_days[]" value="monday">
                        <label class="form-check-label" for="monday">Lundi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="tuesday" name="active_days[]" value="tuesday">
                        <label class="form-check-label" for="tuesday">Mardi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="wednesday" name="active_days[]" value="wednesday">
                        <label class="form-check-label" for="wednesday">Mercredi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="thursday" name="active_days[]" value="thursday">
                        <label class="form-check-label" for="thursday">Jeudi</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="friday" name="active_days[]" value="friday">
                        <label class="form-check-label" for="friday">Vendredi</label>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const activeDaysCheckboxes = document.querySelectorAll('input[name="active_days[]"]');
    const menusContainer = document.getElementById('menus');

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
                            <label for="plat_title_${day}" class="form-label">Titre du Plat Principal</label>
                            <input type="text" class="form-control" id="plat_title_${day}" name="plat_title_${day}" placeholder="Titre du plat principal" required>
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
