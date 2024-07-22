@extends('BackOffice.layouts.app')

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-0">Modifier le Menu</h2>
        </div>
        <div class="card-body">
            <!-- Formulaire de Modification -->
            <form action="{{ route('update', $plat->id) }}" method="POST" class="form-group" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Jour -->
                <div class="mb-3">
                    <label for="jour" class="form-label">Jour</label>
                    <input type="text" class="form-control" id="jour" name="jour" value="{{ old('jour', $jour->jour) }}" disabled>
                </div>

               <!-- Date -->
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="text" class="form-control" id="date" name="date" value="{{ old('date', $date->format('Y-m-d')) }}" disabled>
                </div>


                <!-- Titre du Plat -->
                <div class="mb-4">
                    <h5 class="mb-3" style="text-decoration: underline;">Plat</h5>
                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre du Plat</label>
                        <input type="text" class="form-control" id="titre" name="titre" value="{{ old('titre', $plat->titre) }}" placeholder="Titre du plat" required>
                    </div>
                </div>

                <!-- Boutons de Soumission -->
                <div class="d-flex justify-content-between">
                    <a href="/menus" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Sauvegarder les Modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
