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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('M2M/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('M2M/style.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Font Family M2M -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center topbar-scrolled" style="background-color: #0d4a75;">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <div class="logo me-auto">
        <img src="{{ asset('images/logo.png') }}" alt="M2M Logo" style="height:100%;">
    </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto" href="/admin/active-days-configuration">Configuration</a></li>
          <li><a class="nav-link scrollto" href="/admin/ajouter-menu">Ajout Des Plats</a></li>
          <li><a class="nav-link scrollto" href="/menus">Consultation</a></li>
          <li><a class="nav-link scrollto" href="/statistiques">Statistiques</a></li>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </ul>
      </nav><!-- .navbar -->

      @auth
      <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
      </form>

      <!-- Bouton de déconnexion -->
      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="book-a-table-btn scrollto">Déconnexion</a>
    @endauth


    </div>
  </header><!-- End Header -->

  @yield('content')

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
        <img src="{{ asset('images/Logo-M2M-Group.png') }}" alt="M2M Logo" style="height: 25%;width:25%;">             <p>Bienvenue sur M2M - Votre Solution de Réservation de Repas en Ligne</p>
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
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('M2M/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('M2M/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('M2M/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('M2M/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('M2M/vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('M2M/main.js') }}"></script>
  <script src="{{ asset('M2M/main2.js') }}"></script>
  <script src="{{ asset('M2M/lib/wow/wow.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/easing/easing.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/waypoints/waypoints.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/counterup/counterup.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/owlcarousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/tempusdominus/js/moment.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
  <script src="{{ asset('M2M/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

</body>
</html>
