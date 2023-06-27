<?php

require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/lib/pdo.php";
// require_once __DIR__ . "/lib/services.php";
require_once __DIR__ . "/lib/cars.php";
require_once __DIR__ . "/templates/header-navigation.php";



$cars = getCars($pdo);


?>


<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs">
    <ul class="breadcrumb">
      <li><a href="/">Accueil</a></li>
      <li><a href="#" class="isDisabled">Veicules d'occasion</a></li>
    </ul>
    <div class="go-back-list">
      <a href="#">Revenir liste</a>
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
          <input type="hidden" id="hidden_minimum_kilometers" value="177220">
          <input type="hidden" id="hidden_maximum_kilometers" value="267220">
          <p id="kilometer-show">177220km - 267220km</p>
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
          <h3 class="filter-group-title">Année</h3>
          <input type="hidden" id="hidden_minimum_year" value="177220">
          <input type="hidden" id="hidden_maximum_year" value="267220">
          <p id="year-show">2000 - 2020</p>
          <input type="text" class="btn-wire" value="Réinitialiser">
        </div>

      </article>
      <hr class="filters-diivision">
      <article class="cards">
        <!-- <div class="card">
          <div class="card-header">
            <img class="card-img-top" src="./assets/images/car_card.png" alt="voiture marque X">
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
            <img class="card-img-top" src="./assets/images/car_card.png" alt="voiture marque Y">
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
            <img class="card-img-top" src="./assets/images/car_card.png" alt="voiture marque D">
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
        </div> -->
        <?php foreach ($cars as  $car) { ?>
        <?php require __DIR__ . "/templates/car-part.php" ?>
        <?php }
      ?>
      </article>
    </div>

  </section>
  <!-- END CARS  -->
</div>

<?php
 require_once __DIR__."/templates/footer.php";
?>