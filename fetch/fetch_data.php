<?php
//fetch data filter car

require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";

//check if POST['action'] has value
if (isset($_POST["action"])) {
  $query = "SELECT * FROM cars LEFT JOIN carimages ON cars.id=carimages.product_id WHERE product_id>0 ";


  //kilometers slider
  if (isset($_POST["mininum_kilometer"], $_POST["maximum_kilometer"]) && !empty($_POST["mininum_kilometer"]) && !empty($_POST["maximum_kilometer"])) {
    $query .= "AND kilometers BETWEEN '" . $_POST["mininum_kilometer"] . "' AND '" . $_POST['maximum_kilometer'] . "'";
  }

  //price slider
  if (isset($_POST["mininum_price"], $_POST["maximum_price"]) && !empty($_POST["mininum_price"]) && !empty($_POST["maximum_price"])) {
    $query .= "AND price BETWEEN '" . $_POST["mininum_price"] . "' AND '" . $_POST['maximum_price'] . "'";
  }

  //year slider
  if (isset($_POST["mininum_year"], $_POST["maximum_year"]) && !empty($_POST["mininum_year"]) && !empty($_POST["maximum_year"])) {
    $query .= "AND year BETWEEN '" . $_POST["mininum_year"] . "' AND '" . $_POST['maximum_year'] . "'";
  }

  $query .= " GROUP BY cars.id ORDER BY product_id DESC";

  // var_dump($query);

  // var_dump($query);
  $statement = $pdo->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();

  //var_dump($result);


  //get number of rows in query
  $total_row = $statement->rowCount();
  $output = '';
  $numberPrice = null;

  if ($total_row > 0) {


    foreach ($result as $row) {
      // var_dump($row);
      if ($row['image_path'] === "" || $row['image_path'] === null) {
        $imagePath = _ASSETS_IMAGES_FOLDER_ . "no-image.svg";
      } else {
        $imagePath = _GARAGE_IMAGES_FOLDER_ . $row['image_path'];
      }

      $numberPrice = number_format($row['price'], 0, ',', ' ');
      $numberKilometers = number_format($row['kilometers'], 0, ',', ' ');
      $output .= '
        <div class="card">
        <div class="card-header">
        <img class="card-img-top height-200" loading="lazy" src="' . $imagePath . '" alt="' . $row['brand'] . '" "' . $row['model'] . '" "' . $row['year'] . '>
</div>

<div class="card-body height-280">
  <h4 class="card-title">' . $row['brand'] . '</h4>
  <p>' . $row['model'] . '</p>
  <p class="card-text">
    <span>' . $row['year'] . '</span> | <span>' . $numberKilometers . '</span> km |
    <span>' . $row['gearbox'] . '</span> | <span>' . $row['fuel'] . '</span> 
  </p>
  <hr>
  <p class="price">' . $numberPrice . ' €</p>
  <a href="voiture-details.php?id=' . $row['product_id'] . '" class=" btn-wire large">Details</a>

</div>
</div>
';
    }
  } else {
    $output = '<h3 class="no-cars">Aucune voiture trouvé</h3>';
  }
  echo $output;
}
