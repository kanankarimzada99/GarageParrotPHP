<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['token']) && isset($_POST['token']) && $_SESSION['token'] == $_POST['token']) {


  $id = null;
  $error = false;
  $fileName = null;
  $file_name = null;

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


  $errorEmpty = false;
  $errorService = false;
  $errorDescription = false;
  $errorImage = false;

  //to validate service
  if (empty($service) && empty($description) && (!$file)) {
    echo "<div class='alert alert-danger  m-0 mt-3 mx-1' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_SERVICE_, $service)) {
    echo "<div class='alert alert-danger  m-0' role='alert'>Le service est requis et doit contenir une longueur maximale de 30 caractères.</div>";
    $errorService = true;
  } elseif (!preg_match(_REGEX_DESCRIPTION_, $description)) {
    echo "<div class='alert alert-danger  m-0 mt-3 mx-1' role='alert'>La description est requis. Seulement caractères. De 50 à 150 caractères maximum. </div>";
    $errorDescription = true;
  }

  if (!$file) {
    echo '<div class="alert alert-danger d-inline mt-3 mx-1" role="alert">Le fichier n\'a pas été uploadé</div>';
    $errorImage = true;
    exit();
  }
  //verify if a file is sent
  if (isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != '') {

    $sizeImage = getimagesize($_FILES['image']['tmp_name']);


    if ($sizeImage !== false) {

      // Define the allowed file types and size limit
      $allowed_types = array("image/jpeg", "image/jpg", "image/png", "image/webp");
      $max_size = 1000000; // in bytes

      // Get the file size, type, and name
      $file_size = $_FILES['image']['size'];
      $file_type = image_type_to_mime_type(exif_imagetype($_FILES['image']['tmp_name']));
      $file_name = $_FILES['image']['name'];


      // Validate the file size
      if ($file_size > $max_size) {
        // File size is too large, add an error message
        echo '<div class="alert alert-danger d-inline mt-3  mx-1" role="alert">Image ' . $file_name . ' est trop grand. Elle n\'été pas sauvegardée. Le maximum est ' . filesize($max_size) . '.' . '</div>';
        $errorImage = true;
        exit();
      }

      // Validate the file type
      else if (!in_array($file_type, $allowed_types)) {
        // File type is not allowed, add an error message
        echo '<div class="alert alert-danger d-inline mt-3  mx-1" role="alert">Image ' . $file_name . ' n\'est pas sauvegardée. Seulement jpeg, jpg, png et webp sont permis.</div>';
        $errorImage = true;
        $fileName = slugify($file_name);
        exit();
      }

      // Validate the file is an image
      else if (!getimagesize($_FILES['image']['tmp_name'])) {
        // File is not an image, add an error message
        echo '<div class="alert alert-danger d-inline mt-3  mx-1" role="alert">Image ' . $file_name . ' n\'est pas valide.</div>';
        $errorImage = true;
        exit();
      } else {
        //delete spaces into the name and make name file with lowercase letters
        $fileName = slugify($file_name);

        //generate unique ID for a file
        $fileName = uniqid() . '-' . $fileName;

        //move file image into new location (uploads images folder)  

        if (move_uploaded_file($_FILES['image']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

          if (isset($_FILES['image']['name'])) {

            if (file_exists(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['image']['name'])) {
              //delete old image if new one is uploaded
              unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['image']['name']);
            } else {
              echo '<div class="alert alert-success d-inline mt-3 mx-1" role="alert">Image ' . $file_name . ' n\'est pas valide.</div>';
            }
          }
        } else {
          echo '<div class="alert alert-danger d-inline mt-3 mx-1" role="alert">Le fichier n\'a pas été uploadé.</div>';
          $errorImage = true;
        }
      }
    } else {
      $errorImage = true;
      echo '<div class="alert alert-danger d-inline mt-3 mx-1" role="alert">Il y a un problème avec l\'image ' . $_FILES['image']['name'] . '.' . ' Choisissez une autre.</div>';
      exit();
    }
  }

  if ($errorEmpty !== true && $errorService !== true && $errorDescription !== true && $errorImage !== true) {
    $res = saveService($pdo, $service, $description, $fileName, $id);
  }
  if ($res) {

    echo '<div class="alert alert-success mt-3 mx-1">Le service a bien été sauvegardé.</div>';

    $errorEmpty = false;
    $errorService = false;
    $errorDescription = false;
    $errorImage = false;
  } else {
    echo '<div class="alert alert-danger mt-3 mx-1">Le service n\'a pas été sauvegardé.</div>';
    exit();
  }
}
?>

<script>
  $("#service, #description, #image").removeClass("input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorService = "<?php echo $errorService; ?>";
  var errorDescription = "<?php echo $errorDescription; ?>";
  var errorImage = "<?php echo $errorImage; ?>";

  if (errorEmpty == true) {
    $("#service, #description, #image").addClass("input-error");

  }
  if (errorService == true) {
    $("#service").addClass("input-error");
  }
  if (errorDescription == true) {
    $("#description").addClass("input-error");
  }
  if (errorImage == true) {
    $("#image").addClass("input-error");
  }

  if (errorEmpty == false && errorService == false && errorDescription == false && errorImage == false) {
    $("#service, #description, #image").val("");
    //hide form
    $(".connection-wrapper").hide();
    $('#backPage').removeClass('d-none')
  }
</script>