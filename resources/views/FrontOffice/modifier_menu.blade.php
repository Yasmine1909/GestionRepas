@extends('BackOffice/layouts.app')

@section('content')

    <style>
        .container {
            max-width: 900px;
            margin-top: 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background: #ffffff;
        }

        .card-header {
            background: #ffb03b;
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 15px;
        }

        .card-body {
            padding: 20px;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            background-color:#ffb03b;
            border-color: #ffb03b;
            border-radius: 0.5rem;
        }

        .btn-primary:hover {
            background-color: #ffb03b;
            border-color: #F18F00;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            border-radius: 0.5rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .form-group img {
            border-radius: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            max-width: 150px;
        }

        .form-text {
            margin-top: 10px;
            font-size: 0.875rem;
        }

        .btn-upload {
            display: inline-block;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            color: #495057;
        }

        .btn-upload:hover {
            background-color: #e2e6ea;
        }

        .d-flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
<br><br><br>
    <div class="container my-5">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center mb-0">Modifier le Menu</h2>
            </div>
            <div class="card-body">
                <!-- Formulaire de Modification -->
                <form action="#" method="post" class="form-group" enctype="multipart/form-data">
                    @csrf
                    <!-- Date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date du Menu</label>
                        <input type="date" class="form-control" id="date" name="date" value="2024-07-22" required>
                    </div>

                    <!-- Entrée -->
                    <div class="mb-4">
                        <h5 class="mb-3" style="text-decoration: underline;">Entrée</h5>
                        <div class="mb-3">
                            <label for="entreeTitre" class="form-label">Titre de l'Entrée</label>
                            <input type="text" class="form-control" id="entreeTitre" name="entreeTitre" value="Salade César" placeholder="Titre de l'entrée" required>
                        </div>
                        <div class="mb-3">
                            <label for="entreePhoto" class="form-label">Télécharger la Photo de l'Entrée</label>
                            <input class="form-control btn-upload" type="file" id="entreePhoto" name="entreePhoto">
                            <small class="form-text text-muted">L'image actuelle est :</small>
                            <img src="{{ asset('M2M/img/salade_cesar.jpg') }}" alt="Entrée" class="img-fluid mt-2">
                        </div>
                    </div>

                    <!-- Plat Principal -->
                    <div class="mb-4">
                        <h5 class="mb-3"  style="text-decoration: underline;">Plat Principal</h5>
                        <div class="mb-3">
                            <label for="platTitre" class="form-label">Titre du Plat Principal</label>
                            <input type="text" class="form-control" id="platTitre" name="platTitre" value="Foie Gras" placeholder="Titre du plat principal" required>
                        </div>
                        <div class="mb-3">
                            <label for="platPhoto" class="form-label">Télécharger la Photo du Plat Principal</label>
                            <input class="form-control btn-upload" type="file" id="platPhoto" name="platPhoto">
                            <small class="form-text text-muted">L'image actuelle est :</small>
                            <img src="{{ asset('M2M/img/foie_gras.jpg') }}" alt="Plat Principal" class="img-fluid mt-2">
                        </div>
                    </div>

                    <!-- Dessert -->
                    <div class="mb-4">
                        <h5 class="mb-3"  style="text-decoration: underline;">Dessert</h5>
                        <div class="mb-3">
                            <label for="dessertTitre" class="form-label">Titre du Dessert</label>
                            <input type="text" class="form-control" id="dessertTitre" name="dessertTitre" value="Tiramisu" placeholder="Titre du Dessert" required>
                        </div>
                        <div class="mb-3">
                            <label for="dessertPhoto" class="form-label">Télécharger la Photo du Dessert</label>
                            <input class="form-control btn-upload" type="file" id="dessertPhoto" name="dessertPhoto">
                            <small class="form-text text-muted">L'image actuelle est :</small>
                            <img src="{{ asset('M2M/img/tiramisu.jpg') }}" alt="Dessert" class="img-fluid mt-2">

                        </div>
                    </div>

                    <!-- Boutons de Soumission -->
                    <div class="d-flex-between">
                        <a href="#" class="btn btn-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary">Sauvegarder les Modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
