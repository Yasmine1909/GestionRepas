@extends('BackOffice.layouts.app')

@section('content')
<br><br><br>
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



                <!-- Sélection du Pack -->
                <div class="mb-4">
                    <label for="titre" class="form-label">Plat</label>
                    <select class="form-select" id="titre" name="titre" required>
                        <option value="" disabled selected>Choisissez un pack</option>
                        <option value="Pack1" {{ old('pack', $plat->titre) == 'Pack1' ? 'selected' : '' }}>Pack1</option>
                        <option value="Pack2" {{ old('pack', $plat->titre) == 'Pack2' ? 'selected' : '' }}>Pack2</option>
                        <option value="Pack3" {{ old('pack', $plat->titre) == 'Pack3' ? 'selected' : '' }}>Pack3</option>
                    </select>
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
