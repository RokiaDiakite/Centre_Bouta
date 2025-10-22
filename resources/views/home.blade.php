<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Notre ecole</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{asset('asset/img/favicon.png')}}" rel="icon">
  <link href="{{asset('asset/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('asset/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('asset/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{asset('asset/css/main.css')}}" rel="stylesheet">
</head>

<body class="index-page">
  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" style="margin-top: 80px;">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="{{asset('asset/img/logo.png')}}" alt="">
        <h1 class="sitename">ECOLE</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>

          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted flex-md-shrink-0" href="{{route('login')}}">Connexion</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Bienvenue à notre école</h1>
            <p data-aos="fade-up" data-aos-delay="100">
              Un lieu d’apprentissage, de réussite et d’épanouissement pour chaque élève.
            </p>

            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
              <a href="#about" class="btn-get-started">Voir plus <i class="bi bi-arrow-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="{{asset('asset/img/hero-img.png')}}" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Qui sommes-nous ?</h3>
              <h2>Une école dédiée à la réussite et à l’épanouissement de chaque élève.</h2>
              <p>
                Notre établissement met l’accent sur une formation de qualité, où chaque enfant est accompagné dans son parcours scolaire et personnel.
                Nous offrons un cadre éducatif moderne, des enseignants compétents et passionnés, ainsi que des activités qui favorisent le développement intellectuel, artistique et sportif.
                Notre objectif est de former des élèves responsables, créatifs et prêts à relever les défis de demain.
              </p>

              <div class="text-center text-lg-start">
                <a href="#contact" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>Notre Contact</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="{{asset('asset/img/about.jpg')}}" class="img-fluid" alt="">
          </div>

        </div>
      </div>

    </section><!-- /About Section -->





    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Nos Contact</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <!-- Adresse -->
          <div class="col-md-6 col-lg-6">
            <div class="info-item" data-aos="fade" data-aos-delay="200">
              <i class="bi bi-geo-alt"></i>
              <h3>Adresse</h3>
              <p>ACI 2000</p>
              <p>Rue: 126</p>
              <p>Porte: 54</p>
            </div>
          </div>

          <!-- Contact -->
          <div class="col-md-6 col-lg-6">
            <div class="info-item" data-aos="fade" data-aos-delay="300">
              <i class="bi bi-telephone"></i>
              <h3>Contact</h3>
              <p>+223 76890243</p>
              <p>+223 94870156</p>
            </div>
          </div>

          <!-- Email -->
          <div class="col-md-6 col-lg-6">
            <div class="info-item" data-aos="fade" data-aos-delay="400">
              <i class="bi bi-envelope"></i>
              <h3>Email</h3>
              <p>info@example.com</p>
              <p>contact@example.com</p>
            </div>
          </div>

          <!-- Heure d'ouverture -->
          <div class="col-md-6 col-lg-6">
            <div class="info-item" data-aos="fade" data-aos-delay="500">
              <i class="bi bi-clock"></i>
              <h3>Heure d'ouverture</h3>
              <p>Lundi - Vendredi</p>
              <p>8h00 - 17h00</p>
            </div>
          </div>

        </div>

      </div>

    </section>
    <!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">





    <div class="container copyright text-center mt-4">
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://mdt-informatique.ml/">MDT_Informatique</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('asset/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('asset/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('asset/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('asset/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('asset/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('asset/vendor/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
  <script src="{{asset('asset/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('asset/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Main JS File -->
  <script src="{{asset('asset/js/main.js')}}"></script>

</body>

</html>