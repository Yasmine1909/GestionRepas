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



    </div>
    <!-- End Container -->

</main><!-- End #main -->

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
