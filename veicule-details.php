<?php
 require_once __DIR__."/templates/header.php";
?>


<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs">
    <ul class="breadcrumb">
      <li><a href="#">Accueil</a></li>
      <li><a href="#">Veicules d'occasion</a></li>
      <li><a href="#" class="isDisabled">Renault Clio - 5</a></li>
    </ul>
    <div class="go-back-list">
      <a href="#">Revenir liste</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->


  <!-- CARS  -->
  <section id="cars" class="used-cars sections filtering">
    <h2 class="header-titles">Renault Clio - 5</h2>
    <div class="car">
      <div class="car-images">
        <div class="car-img">
          <img src="./assets/images/car_card.png" alt="clio 5">
        </div>
        <div class="car-thumbnails">
          <img src="./assets/images/car_card.png" alt="view frontal">
          <img src="./assets/images/car_card.png" alt="view frontal">
          <img src="./assets/images/car_card.png" alt="view frontal">
          <img src="./assets/images/car_card.png" alt="view frontal">
        </div>
      </div>
      <div class="car-descriptions">
        <div class="car-accessories">
          <div class="car-accessories-description">
            <span>Modele:</span>
            <span>Clio -5</span>
          </div>
          <div class="car-accessories-description">
            <span>Marque:</span>
            <span>Renault</span>
          </div>

          <div class="car-accessories-description">
            <span>Année:</span>
            <span>2018</span>
          </div>
          <div class="car-accessories-description">
            <span>Kilométrage</span>
            <span>34866</span>
          </div>

          <br>

          <div class="car-accessories-description">
            <span>Color:</span>
            <span>bleue</span>
          </div>
          <div class="car-accessories-description">
            <span>Nombre place:</span>
            <span>5</span>
          </div>
          <div class="car-accessories-description">
            <span>Boite vitesse:</span>
            <span>manuel</span>
          </div>
          <div class="car-accessories-description">
            <span>CO2:</span>
            <span>95 g/km</span>
          </div>

        </div>
        <div class="car-price">4500€</div>
        <div class="car-contact">
          <hr>
          <p>Pour acheter cette voiture, contactez-nous
            au 555-554555 ou avec le formulaire de contact
            en clicant <a href="#" class="car-link-contact">ici</a></p>
        </div>

      </div>
    </div>


  </section>
  <!-- END CARS  -->
</div>



<?php
 require_once __DIR__."/templates/footer.php";
?>