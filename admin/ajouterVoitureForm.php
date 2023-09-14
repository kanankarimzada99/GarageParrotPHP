<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";

$id = null;
$errors = '';
$messages = '';

//for security inputs
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$code = $brand = $model = $year = $kilometer = $gearbox = $doors = $price = $color = $fuel = $co2 = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $code = test_input(($_POST['code']));
  $brand = test_input(($_POST['brand']));
  $model = test_input(($_POST['model']));
  $year = test_input(($_POST['year']));
  $kilometer = test_input(($_POST['kilometer']));
  $gearbox = test_input(($_POST['gearbox']));
  $doors = test_input(($_POST['doors']));
  $price = test_input(($_POST['price']));
  $color = test_input(($_POST['color']));
  $fuel = test_input(($_POST['fuel']));
  $co2 = test_input(($_POST['co2']));

  $imageId = null;
  $imagePath = null;
  //verify if a file is sent

  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];

    // get info about image
    $imageName = $image['name'];
    $imageTmpPath = $image['tmp_name'];

    //delete spaces into the name and make name file with lowercase letters
    $imageId = slugify(basename($_FILES['image']['name']));


    // generate uniq id to the image
    $imageId = uniqid() . '-' . $imageId;

    //regex to image format
    $fileExtensionPattern = '/\.(jpg|jpeg|png|webp)$/i';
    if (preg_match($fileExtensionPattern, $imageId)) {
      // move image to the uploads folder
      $imagePath = dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $imageId;
      move_uploaded_file($imageTmpPath, $imagePath);

      $messages = 'Votre image ete bien envoyé';
    } else {
      $errors = "Le format d'image n'est pas valide. Seulement jpg, jpeg, png ou webp sont permit.";
    }
  } else {
    $errors = "Une erreur s'est produite durant l'envoi.";
  }

  if (empty($errors)) {
    $res = saveCar($pdo, $code, $brand, $model, $year, $kilometer, $gearbox, $doors, $price, $color, $fuel, $co2, $imageId, $id);
  }
}
