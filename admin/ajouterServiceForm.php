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
$file = $_FILES['image']['name'];



if (!$file) {
  echo '<div class="alert alert-danger d-inline" role="alert">Le fichier n\'a pas été uploadé</div>';
  $error = true;
  exit();
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


if ($error == false) {
  $res = saveService($pdo, $service, $description, $fileName, $id);

  if ($res) {

    echo '<div class="alert alert-success">Le service a bien été sauvegardé.</div>';
  } else {
    echo '<div class="alert alert-danger">Le service n\'a pas été sauvegardé.</div>';

    exit();
  }
}
