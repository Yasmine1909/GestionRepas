@extends('BackOffice/layouts.app')

@section('content')

<div class="container" style="margin-bottom:10%;margin-top:10%;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center text-secondary mb-4">Ajouter un Menu</h1>
            <form action="" method="post" class="form-group" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="date" class="form-label">Choisissez un Jour</label>
                    <input type="date" class="form-control" id="date" name="date" required>
                </div>

                <div class="row">
                    {{-- Entrée --}}
                    <div class="col-lg-4 mb-4">
                        <div class="card p-3 h-100">
                            <h4 class="text-center text-secondary mb-4">Entrée</h4>
                            <div class="mb-3">
                                <label for="entree_title" class="form-label">Titre de l'Entrée</label>
                                <input type="text" class="form-control" id="entree_title" name="entree_title" placeholder="Titre de l'entrée" required>
                            </div>
                            <div class="mb-3">
                                <label for="entree_photo" class="form-label">Télécharger la Photo de l'Entrée</label>
                                <input class="form-control" type="file" id="entree_photo" name="entree_photo" required>
                            </div>
                        </div>
                    </div>

                    {{-- Plat --}}
                    <div class="col-lg-4 mb-4">
                        <div class="card p-3 h-100">
                            <h4 class="text-center text-secondary mb-4">Plat Principal</h4>
                            <div class="mb-3">
                                <label for="plat_title" class="form-label">Titre du Plat Principal</label>
                                <input type="text" class="form-control" id="plat_title" name="plat_title" placeholder="Titre du plat principal" required>
                            </div>
                            <div class="mb-3">
                                <label for="plat_photo" class="form-label">Télécharger la Photo du Plat </label>
                                <input class="form-control" type="file" id="plat_photo" name="plat_photo" required>
                            </div>
                        </div>
                    </div>

                    {{-- Dessert --}}
                    <div class="col-lg-4 mb-4">
                        <div class="card p-3 h-100">
                            <h4 class="text-center text-secondary mb-4">Dessert</h4>
                            <div class="mb-3">
                                <label for="dessert_title" class="form-label">Titre du Dessert</label>
                                <input type="text" class="form-control" id="dessert_title" name="dessert_title" placeholder="Titre du dessert" required>
                            </div>
                            <div class="mb-3">
                                <label for="dessert_photo" class="form-label">Télécharger la Photo du Dessert</label>
                                <input class="form-control" type="file" id="dessert_photo" name="dessert_photo" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-block" style="background-color: #ffb03b;">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
