@extends('FrontOffice/layouts.app')


@section('content')


<div class="container" style="margin-bottom:10%;margin-top:15%;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center text-secondary mb-4">Connexion au Compte</h1>
            <form action="" method="post" class="form-group" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez Votre Email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez Votre Mot de Passe" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="#" class="text-secondary">Mot de passe oublié ?</a>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-block" style="background-color: #ffb03b;">Connexion</button>
                </div>
            </form>
        </div>
    </div>
</div>




@endsection
