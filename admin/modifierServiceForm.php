<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";

$id = null;
$error = false;
$fileName = null;

//for security inputs
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$service = $description = '';

$service = test_input(($_POST['service']));
$description = test_input(($_POST['description']));
$file = $_FILES['file']['name'];

if (!$file) {
  echo '<div class="alert alert-danger d-inline" role="alert">Le fichier n\'a pas été uploadé</div>';
  $error = true;
  exit();
}


$id = $_SESSION['service']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $service = ($_POST['service']);
  $description = ($_POST['description']);
  $imageFile = ($_FILES['file']);
  $checkbox = ($_POST['chkbox']);

  $errorImage = false;
  $errorEmpty = false;
  $errorService = false;
  $errorDescription = false;
  $errorImage = false;

  //verify errors inside the form

  //to validate service
  if (empty($service) && empty($description) && !isset($imageFile)) {
    echo  "<div class='alert alert-danger  m-0' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  }


  if (empty($service)) {
    echo   "Le service est requis.";
    $errorService = true;
  } elseif (!preg_match(_REGEX_SERVICE_, $_POST['service'])) {
    echo   "Le service doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.";
    $errorService = true;
  }
  //to validate description
  if (empty($_POST['description'])) {
    echo   "La description est requis.";
    $errorDescription = true;
  } elseif (!preg_match(_REGEX_DESCRIPTION_, $_POST['description'])) {
    echo   "La description doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.";
    $errorDescription = true;
  }

  //to validate image
  if (isset($_POST['chkbox'])) {
    if (empty($_FILES['file'])) {
      echo "L'image pour le service est requis.";
      $errorImage = true;
    }
  }

  //verify if a file is sent
  if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '') {
    $sizeImage = getimagesize($_FILES['image']['tmp_name']);
    if ($sizeImage !== false) {

      //delete spaces into the name and make name file with lowercase letters
      $fileName = slugify(basename($_FILES['image']['name']));

      //generate unique ID for a file
      $fileName = uniqid() . '-' . $fileName;

      //move file image into new location (uploads images folder)  

      if (move_uploaded_file($_FILES['image']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

        if (isset($_FILES['image']['name'])) {



          if (file_exists(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['image']['name'])) {
            //delete old image if new one is uploaded
            unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['image']['name']);
          } else {
            echo '<div class="alert alert-success d-inline" role="alert">image sauvegardé avec success</div>';
          }
        }
      } else {
        echo '<div class="alert alert-danger d-inline" role="alert">Le fichier n\'a pas été uploadé</div>';
      }
    }
  }


  //if no errors we save all information
  if ($errorEmpty !== true && $errorImage !== true && $errorDescription !== true && $errorService !== true) {

    //all data will be saved at saveEmployee function
    if (isset($imageFile)) {
      $res = saveService($pdo, $service, $description, $fileName, $id);
    } else {
      $res = saveService($pdo, $service, $description, $_SESSION['service']['image'], $id);
    }

    if ($res) {
      echo  "<div class='alert alert-success m-0' role='alert'>Le service a bien été sauvegardé.</div>";


      $errorImage = false;
      $errorEmpty = false;
      $errorService = false;
      $errorDescription = false;
      $errorImage = false;
      unset($_SESSION['service']);
    } else {
      echo  "<div class='alert alert-success m-0' role='alert'>Le service a bien été sauvegardé.</div>";
      $errorImage = true;
    }
  }
}
