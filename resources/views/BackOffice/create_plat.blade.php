@extends('FrontOffice/layouts.app')

@section('content')

<div class="container" style="margin-bottom:10%;margin-top:10%;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center text-secondary mb-4">Créer un Plat</h1>
            <form action="" method="post" class="form-group" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="titre" class="form-label">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre" required>
                </div>

                <div class="mb-3">
                    <label for="ingredients" class="form-label">Ingrédients</label>
                    <textarea class="form-control" id="ingredients" placeholder="Citer les Ingrédients" style="height: 100px;" name="ingredients" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="inputGroupSelect01" class="form-label">Type</label>
                    <select class="form-select" id="inputGroupSelect01" name="type" required>
                        <option selected disabled>Choisissez...</option>
                        <option value="entree">Entrée</option>
                        <option value="plat">Plat</option>
                        <option value="dessert">Dessert</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label">Télécharger la Photo du Plat</label>
                    <input class="form-control" type="file" id="formFile" name="photo" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn  btn-block" style="background-color: #ffb03b;">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
