<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>M2M</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('M2M/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('M2M/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('M2M/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('M2M/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('M2M/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('M2M/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('M2M/style.css') }}" rel="stylesheet">
</head>

<body>
    <header id="header" class="fixed-top d-flex align-items-center header-transparent">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <div class="logo me-auto">
                <h1><a href="{{ url('/') }}">M2M</a></h1>
            </div>
            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    <li><a class="nav-link scrollto" href="#about">Réservation </a></li>
                    <li><a class="nav-link scrollto" href="#menu">Menu</a></li>
                    <li><a class="nav-link scrollto" href="#specials">Mes Notifications</a></li>
                    <li><a class="nav-link scrollto" href="#events">Contact</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

            <a href="#book-a-table" class="book-a-table-btn scrollto">Déconnexion</a>

        </div>
    </header><!-- End Header -->

    <div id="calendar" style="margin-right: 20%; margin-left: 20%; margin-bottom: 10%; margin-top: 15%;"></div>

    <!-- Inclure les fichiers JavaScript de FullCalendar -->
    <script src="{{ mix('js/fullcalendar.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['dayGrid', 'timeGrid'],
                initialView: 'dayGridMonth', // Vue initiale par défaut

                eventClassNames: 'custom-event', // Classe CSS globale pour tous les événements
                eventContent: function(arg) {
                    // Fonction pour personnaliser le contenu et les styles de chaque événement
                    return {
                        html: '<b>' + arg.timeText + '</b><br/>' + arg.event.title,
                        classList: ['custom-event'], // Classes CSS supplémentaires si nécessaires
                        backgroundColor: '#ffffff', // Couleur de fond
                        borderColor: '#2e6da4', // Couleur de la bordure
                        textColor: '#000000' // Couleur du texte
                    };
                },

                
            });

            calendar.render();
        });
    </script>

    <footer id="footer">
        <div class="container">
            <h3>M2M</h3>
            <p>Bienvenue sur M2M - Votre Solution de Réservation de Repas en Ligne</p>
            <div class="social-links">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>

        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ asset('M2M/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('M2M/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('M2M/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('M2M/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('M2M/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('M2M/main.js') }}"></script>
    <script src="{{ asset('M2M/dashboard.js') }}"></script>

    <!-- Inclure les fichiers JavaScript de FullCalendar -->
    <script src="{{ asset('node_modules/@fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('node_modules/@fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('node_modules/@fullcalendar/timegrid/main.js') }}"></script>

    <!-- Inclure votre script personnalisé -->

</body>

</html>
