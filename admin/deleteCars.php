<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../lib/carImages.php";

if (isset($_POST['data'])) {
  $dataArr = $_POST['data'];

  foreach ($dataArr as $id) {
    deleteCarImage($pdo, $id);
  }
  echo 'record deleted successfylly';
}
