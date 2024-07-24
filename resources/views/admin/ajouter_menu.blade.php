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
    <h1>Ajouter Menu pour la Semaine Prochaine</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.store_weekly_menu') }}" method="post">
        @csrf

        @foreach($dates as $day => $date)
            <div class="form-group">
                <label for="menu-{{ $date->format('Y-m-d') }}">{{ $day }}, {{ $date->format('d M Y') }}</label>
                <select class="form-control" id="menu-{{ $date->format('Y-m-d') }}" name="menus[{{ $date->format('Y-m-d') }}]">
                    <option value="Pack1">Pack1</option>
                    <option value="Pack2">Pack2</option>
                    <option value="Pack3">Pack3</option>
                </select>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-4 mb-4">Enregistrer</button>
    </form>
</div>
@endsection
