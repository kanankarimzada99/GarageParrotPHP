<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Garage V. Parrot</title>

  <!-- BOOTSTRAP  -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- FONT AWESOME  -->
  <script src="https://kit.fontawesome.com/1a0b88a9d7.js" crossorigin="anonymous"></script>

  <!-- CSS  -->
  <!-- <link rel="stylesheet" href="./assets/css/override-bootstrap.css"> -->
  <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
  <div class="wrapper">
    <header class="header">
      <nav class="nav">
        <a class="logo" href="/">
          <img src="./assets/images/logo_car_title.png" alt="logo garage parrot">
        </a>
        <div class="mobile-menu">
          <div class="line1"></div>
          <div class="line2"></div>
          <div class="line3"></div>
        </div>
        <ul class="nav-list">
          <li>
            <a class="nav-link" aria-current="page" href="#">Accueil</a>
          </li>
          <li>
            <a class="nav-link" aria-current="page" href="#services">Services</a>
          </li>
          <li>
            <a class="nav-link" aria-current="page" href="#cars">Voitures</a>
          </li>
          <li>
            <a class="nav-link" aria-current="page" href="#">Avis</a>
          </li>
          <li>
            <a class="nav-link" aria-current="page" href="#">Horaires</a>
          </li>
          <li>
            <a class="nav-link" aria-current="page" href="#">Contact</a>
          </li>

          <li>
            <a href="#" class="btn-wire">Connecter</a>
          </li>
        </ul>
      </nav>
    </header>
  </div>

  <main class="main">


    <div class="wrapper">

      <!-- BREADCRUMB  -->
      <div class="breadcrumbs">
        <ul class="breadcrumb">
          <li><a href="#">Accueil</a></li>
          <li><a href="#">Veicules d'occasion</a></li>
        </ul>
        <div class="go-back-list">
          <li><a href="#">Revenir liste</a></li>
        </div>
      </div>
      <!-- END BREADCRUMB  -->


      <!-- CARS  -->
      <section id="cars" class="used-cars sections filtering">
        <h2 class="header-titles">Nos voitures d'occasions</h2>
        <div class="filter-cars">
          <article class="filters">

            <div class="filter-group">
              <h3 class="filter-group-title">Kilométrage</h3>
              <input type="hidden" id="hidden_minimum_price" value="177220">
              <input type="hidden" id="hidden_maximum_price" value="267220">
              <p id="price-show">177220km - 267220km</p>
              <input type="text" class="btn-wire" value="Réinitialiser">
            </div>
            <div class="filter-group">
              <h3 class="filter-group-title">Prix</h3>
              <input type="hidden" id="hidden_minimum_price" value="4790">
              <input type="hidden" id="hidden_maximum_price" value="38000">
              <p id="price-show">4790€ - 38000€</p>
              <input type="text" class="btn-wire" value="Réinitialiser">
            </div>
            <div class="filter-group">
              <h3 class="filter-group-title">Kilométrage</h3>
              <input type="hidden" id="hidden_minimum_price" value="177220">
              <input type="hidden" id="hidden_maximum_price" value="267220">
              <p id="price-show">2000 - 2020</p>
              <input type="text" class="btn-wire" value="Réinitialiser">
            </div>

          </article>
          <hr class="filters-diivision" />
          <article class="cards">
            <div class="card">
              <div class="card-header">
                <img class="card-img-top" src="./assets/images/car_hero.png" alt="voiture marque X">
              </div>
              <div class="card-body">
                <h4 class="card-title">Title</h4>
                <p class="card-text">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                  Nesciunt, quidem.
                </p>
                <hr>
                <p class="price">4444€</p>
                <a href="#" class="btn-wire large">Details</a>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <img class="card-img-top" src="./assets/images/car_hero.png" alt="voiture marque Y">
              </div>
              <div class="card-body">
                <h4 class="card-title">Title</h4>
                <p class="card-text">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                  Nesciunt, quidem.
                </p>
                <hr>
                <p class="price">4444€</p>
                <a href="#" class="btn-wire large">Details</a>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                <img class="card-img-top" src="./assets/images/car_hero.png" alt="voiture marque D">
              </div>
              <div class="card-body">
                <h4 class="card-title">Title</h4>
                <p class="card-text">
                  Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                  Nesciunt, quidem.
                </p>
                <hr>
                <p class="price">4444€</p>
                <a href="#" class="btn-wire large">Details</a>
              </div>
            </div>
          </article>
        </div>

      </section>
      <!-- END CARS  -->
    </div>




    <!-- FOOTER   -->

    <footer id="footer" class="footer">
      <div class="footer-logo">
        <img src="./assets/images/logo_white.png" alt="logo garage parrot">
      </div>
      <div class="footer-schedule">
        <div class="footer-local">
          <p class="footer-local-owner">Vicent Parrot</p>
          <div class="footer-phone">
            <i class="fa-solid fa-phone icon"></i>
            <p>555-555-5455</p>
          </div>
          <div class="footer-email">
            <i class="fa-solid fa-envelope icon"></i>
            <p>garageparrot@email.com</p>
          </div>
          <div class="footer-address">
            <p>45 Av. Gen. Foch 31000 Toulouse</p>
          </div>
        </div>
        <div class="footer-days">
          <h5 class="footer-days-title">Horaires d'ouverture</h5>
          <div class="footer-day-week">
            <span class="footer-day">lun:</span>
            <span class="morning-start">08:45</span>
            <span class="morning-end">12:00</span>
            <span> -</span>
            <span class="afternoon-start">14:00</span>
            <span class="afternoon-end">18:00</span>
          </div>
          <div class="footer-day-week">
            <span class="footer-day">mar:</span>
            <span class="morning-start">08:45</span>
            <span class="morning-end">12:00</span>
            <span> -</span>
            <span class="afternoon-start">14:00</span>
            <span class="afternoon-end">18:00</span>
          </div>
          <div class="footer-day-week">
            <span class="footer-day">mer:</span>
            <span class="morning-start">08:45</span>
            <span class="morning-end">12:00</span>
            <span> -</span>
            <span class="afternoon-start">14:00</span>
            <span class="afternoon-end">18:00</span>
          </div>
          <div class="footer-day-week">
            <span class="footer-day">jeu:</span>
            <span class="morning-start">08:45</span>
            <span class="morning-end">12:00</span>
            <span> -</span>
            <span class="afternoon-start">14:00</span>
            <span class="afternoon-end">18:00</span>
          </div>
          <div class="footer-day-week">
            <span class="footer-day">ven:</span>
            <span class="morning-start">08:45</span>
            <span class="morning-end">12:00</span>
            <span> -</span>
            <span class="afternoon-start">14:00</span>
            <span class="afternoon-end">18:00</span>
          </div>
          <div class="footer-day-week">
            <span class="footer-day">sam:</span>
            <span class="morning-start">08:45</span>
            <span class="morning-end">12:00</span>
            <span> -</span>
            <span class="afternoon-start">14:00</span>
            <span class="afternoon-end">18:00</span>
          </div>
          <div class="footer-day-week">
            <span class="footer-day">dim:</span>
            <span class="morning-start">ferme</span>

          </div>

        </div>
      </div>
      <div class="footer-navigation">
        <nav class="footer-nav">

          <ul class="footer-nav-list">
            <li>
              <a class="footer-nav-link" aria-current="page" href="#">Accueil</a>
            </li>
            <li>
              <a class="footer-nav-link" aria-current="page" href="#services">Services</a>
            </li>
            <li>
              <a class="footer-nav-link" aria-current="page" href="#cars">Voitures</a>
            </li>
            <li>
              <a class="footer-nav-link" aria-current="page" href="#">Avis</a>
            </li>
            <li>
              <a class="footer-nav-link" aria-current="page" href="#">Horaires</a>
            </li>
            <li>
              <a class="footer-nav-link" aria-current="page" href="#">Contact</a>
            </li>

            <li>
              <a href="#" class="footer-nav-link">Connecter</a>
            </li>
          </ul>
        </nav>
        <div class="footer-social-network">
          <i class="fa-brands fa-square-facebook"></i>
          <i class="fa-brands fa-square-instagram"></i>
          <i class="fa-brands fa-square-twitter"></i>
        </div>
      </div>
    </footer>

    <!-- END FOOTER   -->


  </main>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
  <script src="./assets/scripts/scripts.js"></script>
</body>

</html>