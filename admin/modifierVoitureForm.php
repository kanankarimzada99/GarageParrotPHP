<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../lib/carImages.php";
// require_once __DIR__ . "/templates/header-admin.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = null;
  $error = false;
  $fileName = null;
  $sizeImage = null;
  $resImages = null;
  $getLastCar = null;

  //for security inputs
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $code = $brand = $model = $year = $kilometer = $gearbox = $doors = $price = $color = $fuel = $co2 = '';


  $code = test_input($_POST['code']);
  $brand = test_input($_POST['brand']);
  $model = test_input($_POST['model']);
  $year = test_input($_POST['year']);
  $kilometer = test_input($_POST['kilometer']);
  $gearbox = test_input($_POST['gearbox']);
  $doors = test_input($_POST['doors']);
  $price = test_input($_POST['price']);
  $color = test_input($_POST['color']);
  $fuel = test_input($_POST['fuel']);
  $co2 = test_input($_POST['co2']);
  $file = $_FILES['file']['name'];

  $errorEmpty = false;
  $errorCode = false;
  $errorBrand = false;
  $errorModel = false;
  $errorYear = false;
  $errorPrice = false;
  $errorKilometers = false;
  $errorColor = false;
  $errorGearbox = false;
  $errorDoors = false;
  $errorFuel = false;
  $errorCO2 = false;
  $errorImage = false;


  $id = test_input($_SESSION['car']['carId']);

  //to validate car
  if (empty($code) && empty($brand) && empty($model) && empty($year) && empty($price) && empty($kilometer) && empty($color) && empty($gearbox) && empty($doors) && empty($fuel) && empty($co2)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_CODE_, $code)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le code doit contenir uniquement des lettres et chiffres. Trois lettres et trois numéros.</div>";
    $errorCode = true;
  } elseif (!preg_match(_REGEX_BRAND_, $brand)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>La marque doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.</div>";
    $errorBrand = true;
  } elseif (!preg_match(_REGEX_MODEL_, $model)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le modèle doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 25 caractères.</div>";
    $errorModel = true;
  } elseif (!preg_match(_REGEX_YEAR_, $year)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>L'anneé doit contenir uniquement des chiffres et avoir une longueur de 4 caractères.</div>";
    $errorYear = true;
  } elseif (!preg_match(_REGEX_GEARBOX_, $gearbox)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>La boîte de vitesses doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.</div>";
    $errorGearbox = true;
  } elseif (!preg_match(_REGEX_DOORS_, $doors)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le numéro de portes doit contenir uniquement des chiffres et avoir une longueur maximale de 2 caractères.</div>";
    $errorDoors = true;
  } elseif (!preg_match(_REGEX_PRICE_, $price)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le prix doit contenir uniquement des chiffres et avoir une longueur maximale de 10 caractères.</div>";
    $errorPrice = true;
  } elseif (!preg_match(_REGEX_COLOR_, $color)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>La couleur doit contenir uniquement des lettres et espaceset avoir une longueur maximale de 15 caractères.</div>";
    $errorColor = true;
  } elseif (!preg_match(_REGEX_FUEL_, $fuel)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le carburant doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.</div>";
    $errorFuel = true;
  } elseif (!preg_match(_REGEX_CO2_, $co2)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le CO2 doit contenir uniquement des chiffres et avoir une longueur maximale de 3 caractères.</div>";
    $errorCO2 = true;
  }






  if ($errorEmpty !== true && $errorCode !== true && $errorBrand !== true && $errorModel !== true && $errorYear !== true && $errorKilometers !== true && $errorGearbox !== true && $errorDoors !== true && $errorPrice !== true && $errorColor !== true && $errorFuel !== true && $errorCO2 !== true) {

    //save car information cars table
    $res = saveCar($pdo, $code, $brand, $model, $year, $kilometer, $gearbox, $doors, $price, $color, $fuel, $co2, $id);




    //to validate image
    if (isset($_POST['imgCar'])) {
      if (empty($_FILES['file']['name'])) {
        echo "L'image pour la voiture est requis.";
      } else {
        // var_dump("sfddddddddddddddddd");
        //verify if a file is sent
        // Handle image uploads
        if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
          $totalImages = count($_FILES['file']['name']);

          // var_dump($totalImages);



          for ($i = 0; $i < $totalImages; $i++) {
            $sizeImage = getimagesize($_FILES['file']['tmp_name'][$i]);
            if ($sizeImage !== false) {

              //delete spaces into the name and make name file with lowercase letters
              $fileName = slugify(basename($_FILES['file']['name'][$i]));

              //generate unique ID for a file
              $fileName = uniqid() . '-' . $fileName;

              //move file image into new location (uploads images folder)  

              if (move_uploaded_file($_FILES['file']['tmp_name'][$i], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

                if (isset($_FILES['file']['name'][$i])) {

                  // $service = getServicesById($pdo, $_SESSION['service']['id']);

                  if (file_exists(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name'][$i])) {
                    //delete old image if new one is uploaded
                    unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name'][$i]);
                  } else {
                    echo '<div class="alert alert-success d-inline" role="alert">image sauvegardé avec success</div>';
                  }
                }
                // $resImages = saveCarImages($pdo, $product_id, $image_path);
              } else {
                echo '<div class="alert alert-danger d-inline" role="alert">Le fichier n\'a pas été uploadé</div>';
              }
            }
            // $imageTmpPath = $_FILES['images']['tmp_name'][$i];
            // $imageName = $_FILES['images']['name'][$i];
            // $imagePath = "/uploads/images/" . $imageName; // Assuming uploads/ is a directory for storing images

            // // Move uploaded image to the 'uploads' directory
            // move_uploaded_file($imageTmpPath, $imagePath);

            // //get id last car
            // $getLastCar = getLastCar($pdo);
            // // var_dump($getLastCar['id']);
            // // var_dump($getLastCar);


            // var_dump($_POST);

            // var_dump($fileName);
            // // var_dump($getLastCar['id']);
            // var_dump($_SESSION['car']['image_path']);
            // var_dump($_SESSION['car']);
            // var_dump($_SESSION['images']);

            if ($file) {

              //save images inside carimages
              $resImages = saveCarImages($pdo, $fileName, $id);
            } else {

              //save images inside carimages
              $resImages = saveCarImages($pdo, $_SESSION['car']['image_path'], $id);
            }
          }
        }
      }
    }

    if ($res) {

      echo '<div class="alert alert-success">La voiture a bien été sauvegardé.</div>';
      unset($_SESSION['car']);
      unset($_SESSION['images']);
    } else {
      echo '<div class="alert alert-danger">La voiture n\'a pas été sauvegardé.</div>';

      exit();
    }
  }
} else {
  echo "<div class='alert alert-danger m-0' role='alert'>Une erreur s'est produite durant l'envoi.</div>";
  $errorEmpty = true;
}



?>
<script>
  $("#code, #brand, #model, #year, #kilometer, #gearbox, #doors, #price, #color, #fuel, #co2").removeClass(
    "input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorCode = "<?php echo $errorCode; ?>";
  var errorBrand = "<?php echo $errorBrand; ?>";
  var errorModel = "<?php echo $errorModel; ?>";
  var errorYear = "<?php echo $errorYear; ?>";
  var errorPrice = "<?php echo $errorPrice; ?>";
  var errorKilometers = "<?php echo $errorKilometers; ?>";
  var errorColor = "<?php echo $errorColor; ?>";
  var errorGearbox = "<?php echo $errorGearbox; ?>";
  var errorDoors = "<?php echo $errorDoors; ?>";
  var errorFuel = "<?php echo $errorFuel; ?>";
  var errorCO2 = "<?php echo $errorCO2; ?>";
  var errorImage = "<?php echo $errorImage; ?>";


  if (errorEmpty == true) {
    $("#code, #brand, #model, #year, #kilometer, #gearbox, #doors, #price, #color, #fuel, #co2").addClass("input-error");
  }
  if (errorCode == true) {
    $("#code").addClass("input-error");
  }
  if (errorBrand == true) {
    $("#brand").addClass("input-error");
  }
  if (errorModel == true) {
    $("#model").addClass("input-error");
  }
  if (errorYear == true) {
    $("#year").addClass("input-error");
  }
  if (errorPrice == true) {
    $("#price").addClass("input-error");
  }
  if (errorKilometers == true) {
    $("#kilometer").addClass("input-error");
  }
  if (errorColor == true) {
    $("#color").addClass("input-error");
  }
  if (errorGearbox == true) {
    $("#gearbox").addClass("input-error");
  }
  if (errorDoors == true) {
    $("#doors").addClass("input-error");
  }
  if (errorFuel == true) {
    $("#fuel").addClass("input-error");
  }
  if (errorCO2 == true) {
    $("#co2").addClass("input-error");
  }
  if (errorImage == true) {
    $("#file").addClass("input-error");
  }



  if (errorEmpty == false && errorCode == false && errorBrand == false && errorModel == false && errorYear == false &&
    errorPrice == false && errorKilometers == false && errorColor == false && errorGearbox == false && errorDoors ==
    false && errorFuel == false && errorCO2 == false && errorImage == false) {
    $("#code, #brand, #model, #year, #kilometer, #gearbox, #doors, #price, #color, #fuel, #co2, #file").val("");

    $(".connection-wrapper").hide();
    //hide message after 4 seconds
    setTimeout(function() {
      // $('.form-message').hide();
      window.location = '/admin/liste-voitures.php';

    }, 3500); // <-- time in milliseconds
  }
</script>