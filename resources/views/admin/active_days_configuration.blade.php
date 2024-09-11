@extends('BackOffice.layouts.app')

@section('content')
<br><br><br><br><br><br>
<main id="main" class="py-5">

    <!-- Container -->
    <div class="container">

        <!-- Success Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Alert -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Card for Active Days Configuration -->
        <div class="card shadow-sm border-light mb-4">
            <div class="card-header text-white" style="background-color: #0d4a75">
                <h4 class="mb-0 text-white">Configuration des Jours Actifs</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.save_active_days_configuration') }}" method="post">
                    @csrf
                    <div class="row mb-4">
                        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $day)
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="{{ $day }}" name="active_days[]" value="{{ $day }}"
                                           {{ in_array($day, $activeDays) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $day }}">{{ $day }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">Enregistrer</button>
                </form>
            </div>
        </div>

<!-- Card for Email Configuration -->
<div class="card shadow-sm border-light mb-4">
    <div class="card-header text-white" style="background-color: #0d4a75">
        <h4 class="mb-0 text-white">Configurer l'Envoi des Emails</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('email.settings.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="activer" name="email_setting" value="1"
                    {{ $emailSetting->enabled ? 'checked' : '' }}>
                <label class="form-check-label" for="activer">Activer</label>

                </div>
                <div class="form-check">

                <input class="form-check-input" type="radio" id="desactiver" name="email_setting" value="0"
                {{ !$emailSetting->enabled ? 'checked' : '' }}>
            <label class="form-check-label" for="desactiver">Désactiver</label>

                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Enregistrer</button>
        </form>
    </div>
</div>
<!-- Card for Reminder Emails -->
<div class="card shadow-sm border-light mb-4">
    <div class="card-header text-white" style="background-color: #0d4a75">
        <h4 class="mb-0 text-white">Envoyer un Rappel par Email</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.send_reminder_emails') }}" method="post">
            @csrf
            <!-- Type de rappel -->
            <div class="form-group mb-4">
                <label for="reminder_type">Type de Rappel :</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="premier_rappel" name="reminder_type" value="premier_rappel" checked>
                    <label class="form-check-label" for="premier_rappel">Premier Rappel</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="dernier_rappel" name="reminder_type" value="dernier_rappel">
                    <label class="form-check-label" for="dernier_rappel">Dernier Rappel</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="autre" name="reminder_type" value="autre">
                    <label class="form-check-label" for="autre">Message Personnalisé</label>
                </div>
            </div>

            <!-- Message personnalisé -->
            <div class="form-group mb-4" id="custom_message_block" style="display: none;">
                <label for="custom_message">Message Personnalisé :</label>
                <textarea class="form-control" id="custom_message" name="custom_message" rows="3" placeholder="Tapez votre message personnalisé ici..."></textarea>
            </div>

            <!-- Bouton d'envoi -->
            <button type="submit" class="btn btn-primary btn-lg">Envoyer le Rappel</button>
        </form>
    </div>

    <!-- Card for Importing Users from Excel -->
</div>
<div class="card shadow-sm border-light mb-4">
    <div class="card-header text-white" style="background-color: #0d4a75">
        <h4 class="mb-0 text-white">Importer des Utilisateurs depuis un Fichier Excel</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.import_users') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label for="users_excel">Fichier Excel :</label>
                <input type="file" class="form-control" id="users_excel" name="users_excel" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Importer</button>
        </form>
    </div>
</div>

<!-- Script pour afficher/masquer le champ de message personnalisé -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const customMessageBlock = document.getElementById('custom_message_block');
        const customRadio = document.getElementById('autre');

        customRadio.addEventListener('change', function () {
            if (customRadio.checked) {
                customMessageBlock.style.display = 'block';
            }
        });

        document.getElementById('premier_rappel').addEventListener('change', function () {
            customMessageBlock.style.display = 'none';
        });

        document.getElementById('dernier_rappel').addEventListener('change', function () {
            customMessageBlock.style.display = 'none';
        });
    });
</script>



    </div>
    <!-- End Container -->

</main><!-- End #main -->

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
