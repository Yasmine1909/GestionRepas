@extends('FrontOffice.layouts.app')

@section('content')
    <style>
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }

        .container {
            margin-top: 5%;
        }

        .table-title {
            background-color: #35322d;
            color: #ffffff;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        .notification {
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        .notification-success {
            background-color: #d4edda;
            color: #155724;
        }

        .notification-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .hide {
            display: none;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 0;
            margin: 1rem 0;
            list-style: none;
        }

        .pagination li {
            margin: 0 4px;
        }

        .pagination li a,
        .pagination li span {
            color: #007bff;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .pagination li a:hover,
        .pagination li span:hover {
            background-color: #e2e6ea;
            color: #0056b3;
            border-color: #0056b3;
        }

        .pagination li.active span {
            color: #ffffff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .pagination li.disabled span {
            color: #6c757d;
            background-color: #ffffff;
            border-color: #dee2e6;
        }

        .pagination .page-item:first-child a,
        .pagination .page-item:first-child span {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .pagination .page-item:last-child a,
        .pagination .page-item:last-child span {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }
    </style>

    <div class="container" style="margin-top: 12%;">
        <div class="search-bar mb-4">
            <form action="{{ route('notifications.search') }}" method="GET" class="form-inline">
                <input type="text" name="query" class="form-control mr-2" placeholder="Rechercher par date ou plat">
                <button type="submit" class="btn btn-primary mt-2">Rechercher</button>
            </form>

        </div>

        <h1 class="table-title text-center">Notifications</h1>

        <!-- Notifications -->
        @foreach($notifications as $notification)
            <div class="notification notification-{{ $notification->type }}">
                <p>{{ $notification->message }}</p>
                <p>à: {{ $notification->created_at->format('d-m-Y H:i') }}</p>
            </div>
        @endforeach

        <!-- Pagination Links -->
        <nav aria-label="Page navigation">
            @include('vendor.pagination.simple-custom', ['paginator' => $notifications])
        </nav>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
