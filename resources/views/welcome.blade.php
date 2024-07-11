<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>M2M Bootstrap Template - Index</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('M2M/img/favicon.png') }}" rel="icon">
  <link href="{{ asset('M2M/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,600,600i,700,700i|Satisfy|Comic+Neue:300,300i,400,400i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('M2M/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('M2M/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('M2M/style.css') }}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: M2M
  * Template URL: https://bootstrapmade.com/M2M-free-restaurant-bootstrap-theme/
  * Updated: May 16 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>



  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center header-transparent">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <div class="logo me-auto">
        <h1><a href="{{ url('/') }}">M2M</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="{{ url('/') }}"><img src="{{ asset('M2M/img/logo.png') }}" alt="" class="img-fluid"></a>-->
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

  <!-- ======= Hero Section ======= -->
  <section id="hero">
    <div class="hero-container">
        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

              <!-- Slide 1 -->
              <div class="carousel-item active" style="background-image: url('{{ asset('M2M/img/accueil.jpg') }}');">
                <div class="carousel-container">
                  <div class="carousel-content">
                    <h2 class="animate__animated animate__fadeInDown"><span>Réservez vos repas pour la semaine à venir</span> </h2>
                    <div>
                      <a href="#menu" class="btn-menu animate__animated animate__fadeInUp scrollto">Notre Menu</a>
                      <a href="#book-a-table" class="btn-book animate__animated animate__fadeInUp scrollto">Réservez</a>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container-fluid">

        <div class="row">

          <div class="col-lg-5 align-items-stretch video-box" style='background-image: url("{{ asset('M2M/img/about.jpg') }}");'>
            <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn mb-4"></a>
          </div>

          <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">

            <div class="content">
                <h3>Découvrez notre solution de réservation de repas en ligne</h3>
                <p>Bienvenue sur M2M - Votre Solution de Réservation de Repas en Ligne.</p>
                <p class="fst-italic">Notre plateforme facilite la réservation des repas pour les employés, assurant une organisation efficace et sans tracas.</p>
                <ul>
                    <li><i class="bx bx-check-double"></i> Gestion complète des réservations : ajout, modification et suppression.</li>
                    <li><i class="bx bx-check-double"></i> Consultation facile et rapide des réservations enregistrées.</li>
                    <li><i class="bx bx-check-double"></i> Notifications personnalisées pour vous informer des mises à jour importantes.</li>
                </ul>
                <p>Notre plateforme permet aux employés de réserver leurs repas en toute simplicité, assurant une gestion efficace et une expérience utilisateur optimale.</p>
            </div>


          </div>

        </div>

      </div>
    </section><!-- End About Section -->






  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
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
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>


</body>

</html>
