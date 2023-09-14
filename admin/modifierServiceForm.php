<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";




$id = null;
$formService = [
  'service' => '',
  'description' => ''
];


$service = $description = '';

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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

  $imageId = null;
  //verify if a file is sent
  if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['file'];

    // get info about image
    $imageName = $image['name'];
    $imageTmpPath = $image['tmp_name'];

    //delete spaces into the name and make name file with lowercase letters
    $imageId = slugify(basename($_FILES['file']['name']));


    // generate uniq id to the image
    $imageId = uniqid() . '-' . $imageId;

    //regex to image format
    $fileExtensionPattern = '/\.(jpg|jpeg|png|webp)$/i';
    if (preg_match($fileExtensionPattern, $imageId)) {
      // move image to the uploads folder
      $imagePath = dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $imageId;
      move_uploaded_file($imageTmpPath, $imagePath);

      echo 'Votre image ete bien envoyé';
      $errorImage = false;
    } else {
      echo   "Le format d'image n'est pas valide. Seulement jpg, jpeg, png ou webp sont permit.";
      $errorImage = true;
    }
  } else {
    echo  "<div class='alert alert-danger m-0' role='alert'>L'image est requis.</div>";
    $errorImage = true;
  }


  //if no errors we save all information
  if ($errorEmpty !== true && $errorImage !== true && $errorDescription !== true && $errorService !== true) {

    //all data will be saved at saveEmployee function
    if (isset($imageFile)) {
      $res = saveService($pdo, $service, $description, $imageId, $id);
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
