@extends('FrontOffice.layouts.app')

@section('content')
    <style>
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
        }
        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
        .table {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        thead {
            background-color: #f8f9fa;
        }
        thead th {
            color: #495057;
            font-weight: 600;
        }
        tbody td {
            vertical-align: middle;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
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
        .consultation-only {
            color: #6c757d;
        }
        .actions {
            display: flex;
            gap: 0.5rem;
        }
        .search-bar {
            margin-bottom: 2rem;
        }
        .hide {
            display: none;
        }
        .notification {
            margin-bottom: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .notification-success {
            background-color: #d4edda;
            color: #155724;
        }
        .notification-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>

    <div class="container" style="margin-top:15%;">
        <div class="search-bar">
            <form id="searchForm" class="form-inline">
                <input type="text" id="searchText" class="form-control mr-2" placeholder="Rechercher par date ou plat">
                <button type="button" onclick="filterNotifications()" class="btn btn-primary mt-2">Rechercher</button>
            </form>
        </div>

        <h1 class="table-title text-center">Notifications</h1>

        <!-- Notifications -->
        @foreach($notifications as $notification)
            <div class="notification notification-{{ $notification->type }}">
                <p>{{ $notification->message }} <p>à: {{ $notification->created_at->format('d-m-Y H:i') }}</p>
            </body></p>

            </div>
        @endforeach
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function filterNotifications() {
            const searchText = document.getElementById('searchText').value.toLowerCase();
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                const text = notification.textContent.toLowerCase();
                if (text.includes(searchText)) {
                    notification.classList.remove('hide');
                } else {
                    notification.classList.add('hide');
                }
            });
        }
    </script>
@endsection
