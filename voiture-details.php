<?php

require_once __DIR__ . "/lib/config.php";
require_once __DIR__ . "/lib/session.php";
require_once __DIR__ . "/lib/pdo.php";
require_once __DIR__ . "/lib/cars.php";
require_once __DIR__ . "/templates/header-navigation.php";

$cars = getCars($pdo);

 //verify if id is on the URL
 $error = false;
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $car = getCarsById($pdo, $id);

    // verify if image id exist 
       if($car['image'] === ""){
      $imagePath = 'assets/images/no-image.svg';
    }else {
      $imagePath = 'uploads/images/'.$car['image'];
    }
 
    //verify if car is on db
    if(!$car) {
      $error = true;
    }
}else{
  $error = true;
}
?>

<?php if(!$error)
{?>
<div class="wrapper">

  <!-- BREADCRUMB  -->
  <?php require __DIR__ . "/templates/breadcrumb-part.php"; ?>
  <!-- END BREADCRUMB  -->

  <!-- CARS  -->
  <section id="cars" class="used-cars sections filtering">
    <h1 class="header-titles"><span><?=$car['brand'];?></span> - <span><?=$car['model'];?></h2>
        <div class="car">
          <div class="car-images">
            <div class="car-img">
              <img class="card-img-top" src="<?=$imagePath;?>" alt="<?=$car['model'];?>">
            </div>
            <!-- <div class="car-thumbnails">
              <img src="./uploads/images/car-card.png" alt="view frontal">
              <img src="./uploads/images/car-card.png" alt="view frontal">
              <img src="./uploads/images/car-card.png" alt="view frontal">
              <img src="./uploads/images/car-card.png" alt="view frontal">
            </div> -->
          </div>
          <div class="car-descriptions">
            <div class="car-accessories">
              <div class="car-accessories-description">
                <span>Marque:</span>
                <span><?=$car['brand'];?></span>
              </div>
              <div class="car-accessories-description">
                <span>Modele:</span>
                <span><?=$car['model'];?></span>
              </div>

              <div class="car-accessories-description">
                <span>Année:</span>
                <span><?=$car['year'];?></span>
              </div>
              <div class="car-accessories-description">
                <span>Kilométrage:</span>
                <span><?=$car['kilometers'];?></span>
              </div>

              <br>

              <div class="car-accessories-description">
                <span>Color:</span>
                <span><?=$car['color'];?></span>
              </div>
              <div class="car-accessories-description">
                <span>Nombre place:</span>
                <span><?=$car['number_doors'];?></span>
              </div>
              <div class="car-accessories-description">
                <span>Boite vitesse:</span>
                <span><?=$car['gearbox'];?></span>
              </div>
              <div class="car-accessories-description">
                <span>CO2:</span>
                <span><?=$car['co'];?> g/km</span>
              </div>
            </div>

            <!-- number format 2 000,00 €  -->
            <div class="car-price"><?=number_format($car['price'], 2, ',', ' ');?> €</div>
            <div class="car-contact">
              <hr>
              <p>Pour acheter cette voiture, contactez-nous
                au 555-554555 ou avec le formulaire de contact
                en clicant <a href="voiture-contact.php?id=<?=$car['id'];?>" class="car-link-contact">ici</a></p>
            </div>
          </div>
        </div>
  </section>
  <!-- END CARS  -->
</div>

<?php
 require_once __DIR__."/templates/footer.php";
?>

<?php } else {?>
<div class="not-found">
  <h1 class="not-found-text">Voiture introuvable</h1>
  <div class="go-back-page">
    <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
  </div>
</div>
<?php } ?>