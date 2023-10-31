<?php

require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
// require_once __DIR__ . "/../lib/carImages.php";
require_once __DIR__ . "/../templates/header-navigation.php";

$cars = getCars($pdo);

// var_dump($cars);

//verify if id is on the URL
$error = false;
if (isset($_GET['id'])) {

  //Get the integer value of $_GET['id']. 
  $id = intval($_GET['id']);

  //get car by Id url
  $car = getCarsById($pdo, $id);

  // var_dump($car['id']);


  //get images car by id url
  $carImages = getCarImagesById($pdo, $id);



  // var_dump($carImages);

  if (isset($car["image_path"]) && $car['image_path'] !== "" && $car['image_path'] !== null) {
    $imagePath =  _GARAGE_IMAGES_FOLDER_ . $car["image_path"];
  } else {
    $imagePath = _ASSETS_IMAGES_FOLDER_ . "no-image.svg";
  }

  if (!$car) {
    $error = true;
  }
} else {
  $error = false;
}
?>


<div class="wrapper">

  <?php if ($car) : ?>

  <!-- BREADCRUMB  -->
  <?php require __DIR__ . "/../templates/breadcrumb-part.php"; ?>
  <!-- END BREADCRUMB  -->

  <!-- messages  -->
  <div id="form-message" class="my-3 d-flex justify-content-center"></div>

  <!-- CARS  -->
  <section id="cars" class="used-cars sections filtering">
    <h1 class="header-titles"><span><?= $car['brand']; ?></span> - <span><?= $car['model']; ?></h2>
        <div class="car">
          <div class="car-images">
            <div class="car-img">
              <img id='imageBox' class="card-img-top" src="<?= $imagePath; ?>" alt="<?= $car['model']; ?>">
            </div>

            <div class="container">
              <div class="row my-3">
                <?php foreach ($carImages as $car) { ?>
                <div class="car-thumbnails-img col-6 col-sm-4 mb-3 ">
                  <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars_decode($car['image_path']) ?>"
                    alt="<?= $car['brand'] ?>" onmouseover='myFunction(this)'>
                </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="car-descriptions">
            <div class="car-accessories">
              <div class="car-accessories-description">
                <span>Marque:</span>
                <span><?= $car['brand']; ?></span>
              </div>
              <div class="car-accessories-description">
                <span>Modele:</span>
                <span><?= $car['model']; ?></span>
              </div>

              <div class="car-accessories-description">
                <span>Année:</span>
                <span><?= $car['year']; ?></span>
              </div>
              <div class="car-accessories-description">
                <span>Kilométrage:</span>
                <span><?= $car['kilometers']; ?></span>
              </div>

              <br>

              <div class="car-accessories-description">
                <span>Color:</span>
                <span><?= $car['color']; ?></span>
              </div>
              <div class="car-accessories-description">
                <span>Nombre place:</span>
                <span><?= $car['number_doors']; ?></span>
              </div>
              <div class="car-accessories-description">
                <span>Boite vitesse:</span>
                <span><?= $car['gearbox']; ?></span>
              </div>
              <div class="car-accessories-description">
                <span>CO2:</span>
                <span><?= $car['co']; ?> g/km</span>
              </div>
            </div>

            <!-- number format 2 000,00 €  -->
            <div class="car-price"><?= number_format($car['price'], 2, ',', ' '); ?> €</div>
            <div class="car-contact">
              <hr>
              <p>Pour acheter cette voiture, contactez-nous
                au 555-554555 ou avec le formulaire de contact
                en clicant <a href="voiture-contact.php?id=<?= $id; ?>" class="car-link-contact">ici</a>
              </p>
            </div>
          </div>
        </div>
  </section>
  <!-- END CARS  -->
</div>

<?php else : ?>
<div id="form-message" class="d-flex justify-content-center">
  <div class='d-flex justify-content-center  alert alert-danger mt-5 mb-3 mx-auto' role='alert'>Cette voiture n'existe
    pas</div>
</div>


<div class="go-back-page my-3 d-flex justify-content-center">
  <a href="javascript:history.back(1)" class="btn-wire mb-5">Retour page précédante</a>
</div>

<?php endif ?>

<script>
const myFunction = (smallImg) => {
  let fullImg = document.getElementById('imageBox')
  fullImg.src = smallImg.src
}
</script>
<?php
require_once __DIR__ . "/../templates/footer.php";
?>