@extends('BackOffice.layouts.app')

@section('content')

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<div class="container">
    <h1>Configurer les Jours Actifs</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form action="{{ route('admin.save_active_days_configuration') }}" method="post">
        @csrf
        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'] as $day)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="{{ $day }}" name="active_days[]" value="{{ $day }}"
                       {{ in_array($day, $activeDays) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $day }}">{{ $day }}</label>
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary mt-2 mb-2">Enregistrer</button>
    </form>
</div>
@endsection
