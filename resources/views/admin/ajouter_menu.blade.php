@extends('BackOffice.layouts.app')

@section('content')
<br><br><br><br><br><br>
<main id="main" class="py-5">

    <!-- Container -->
    <div class="container">

        <!-- Card -->
        <div class="card shadow-lg border-light">
            <div class="card-header  text-white" style="background-color: #0d4a75;">
                <h4 class="mb-0 text-white">Ajouter Menu pour la Semaine Prochaine</h4>
            </div>
            <div class="card-body">

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

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('admin.store_weekly_menu') }}" method="post">
                    @csrf
                    @foreach($dates as $day => $date)
                        <div class="form-group mb-4">
                            <label for="menu-{{ $date->format('Y-m-d') }}" class="form-label">
                                <span class="text-muted">{{ $day }}</span>, <span class="font-weight-bold">{{ $date->format('d M Y') }}</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="menu-{{ $date->format('Y-m-d') }}" name="menus[{{ $date->format('Y-m-d') }}]" placeholder="Entrez le menu">
                        </div>
                    @endforeach
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
