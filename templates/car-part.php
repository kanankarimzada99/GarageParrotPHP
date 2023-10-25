<!-- if image car doesn't exist  -->
<?php

// var_dump($car);
if ($car['image_path'] === "" || $car['image_path'] === null) {
  $imagePath = _ASSETS_IMAGES_FOLDER_ . "no-image.svg";
} else {
  $imagePath = _GARAGE_IMAGES_FOLDER_ . $car['image_path'];
}
?>

<div class="card">
  <div class="card-header">
    <img class="card-img-top height-200" src="<?= $imagePath; ?>"
      alt="<?= $car['brand'] . " " . $car['model'] . " " . $car['year']; ?>">
  </div>
  <div class="card-body ">
    <h4 class="card-title"><?= $car['brand']; ?></h4>
    <p><?= $car['model']; ?></p>
    <p class="card-text">
      <span><?= $car['year']; ?></span> | <span><?= $car['kilometers'] ?></span> |
      <span><?= $car['gearbox']; ?></span> | <span><?= $car['fuel']; ?></span>
    </p>
    <hr>
    <!-- number format 2 000,00 €  -->
    <p class="price"><?= number_format($car['price'], 2, ',', ' '); ?> €</p>
    <a href="/pages/voiture-details.php?id=<?= $car['product_id']; ?>" class=" btn-wire large">Details</a>
  </div>
</div>