@extends('FrontOffice/layouts.app')

@section('content')
<div class="container" style="margin-bottom:10%;margin-top:15%;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="text-center text-secondary mb-4">Connexion au Compte</h1>


            <form action="{{ route('login') }}" method="post" class="form-group" enctype="multipart/form-data">
                @csrf


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Entrez Votre Email" required>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Mot de Passe</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Entrez Votre Mot de Passe" required>
                </div>


                <div class="d-grid">
                    <button type="submit" class="btn btn-block" style="background-color: #ffb03b;">Connexion</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
