
@extends('FrontOffice/layouts.app')


@section('content')



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
                      <a href="Dashboard" class="btn-book animate__animated animate__fadeInUp scrollto">Réservez</a>
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



@endsection
