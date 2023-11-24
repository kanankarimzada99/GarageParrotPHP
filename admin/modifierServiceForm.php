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
  $sizeImage = null;
  $resImages = null;

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

  $errorImage = false;
  $errorEmpty = false;
  $errorService = false;
  $errorDescription = false;
  $errorImage = false;

  $id = test_input($_SESSION['service']['id']);

  //verify errors inside the form

  //to validate service
  if (empty($service) && empty($description)) {
    echo  "<div class='alert alert-danger d-inline mt-3 mx-1' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_SERVICE_, $service)) {
    echo   "<div class='alert alert-danger d-inline mt-3 mx-1' role='alert'>Le service doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.</div>";
    $errorService = true;
  } elseif (!preg_match(_REGEX_DESCRIPTION_, $description)) {
    echo   "<div class='alert alert-danger d-inline mt-3 mx-1' role='alert'>La description doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.</div>";
    $errorDescription = true;
  }

  //to validate image
  if (isset($_POST['imgCar'])) {
    if (empty($_FILES['file']['name'])) {
      echo "<div class='alert alert-danger d-inline mt-3 mx-1' role='alert'>L'image pour le service est requis.</div>";
    } else {
      //verify if a file is sent
      if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {

        $sizeImage = getimagesize($_FILES['file']['tmp_name']);


        if ($sizeImage !== false) {

          // Define the allowed file types and size limit
          $allowed_types = array("image/jpeg", "image/jpg", "image/png", "image/webp");
          $max_size = 1000000; // in bytes

          // Get the file size, type, and name
          $file_size = $_FILES['file']['size'];
          $file_type = image_type_to_mime_type(exif_imagetype($_FILES['file']['tmp_name']));
          $file_name = $_FILES['file']['name'];


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
            echo '<div class="alert alert-danger d-inline mt-3  mx-1" role="alert">Image ' . $file_name . ' n\'est pas sauvegardé. Seulement jpeg, jpg, png et webp sont permis.</div>';
            $errorImage = true;
            $fileName = slugify($file_name);
            exit();
          }

          // Validate the file is an image
          else if (!getimagesize($_FILES['file']['tmp_name'])) {
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

            if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

              if (isset($_FILES['file']['name'])) {

                if (file_exists(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name'])) {
                  //delete old image if new one is uploaded
                  unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name']);
                } else {
                  echo '<div class="alert alert-success d-inline mt-3 mx-1" role="alert">Image ' . $file_name . ' est sauvegardé avec success.</div>';
                }
              }
            } else {
              echo '<div class="alert alert-danger d-inline mt-3 mx-1" role="alert">Le fichier n\'a pas été uploadé</div>';
              $errorImage = true;
            }
          }
        } else {
          $errorImage = true;
          echo '<div class="alert alert-danger d-inline mt-3 mx-1" role="alert">Il y a un problème avec l\'image ' . $_FILES['file']['name'] . '.' . ' Choisissez une autre.</div>';
          exit();
        }
      }
    }
  }

  //if no errors we save all information
  if ($errorEmpty !== true && $errorImage !== true && $errorDescription !== true && $errorService !== true) {

    //all data will be saved at saveEmployee function
    if ($file) {
      $res = saveService($pdo, $service, $description, $fileName, $id);
    } else {
      $res = saveService($pdo, $service, $description, $_SESSION['service']['image'], $id);
    }

    if ($res) {
      echo  "<div class='alert alert-success d-inline mt-3' role='alert'>Le service a bien été sauvegardé.</div>";

      $errorImage = false;
      $errorEmpty = false;
      $errorService = false;
      $errorDescription = false;
      $errorImage = false;

      //empty session service
      unset($_SESSION['service']);
    } else {
      echo  "<div class='alert alert-success d-inline mt-3' role='alert'>Le service a bien été sauvegardé.</div>";
      $errorImage = true;
    }
  }
}

?>
<script>
  $("#service, #description, #file").removeClass("input-error");

  //get variable php inside js
  var errorEmpty = "<?php echo $errorEmpty; ?>";
  var errorService = "<?php echo $errorService; ?>";
  var errorDescription = "<?php echo $errorDescription; ?>";
  var errorImage = "<?php echo $errorImage; ?>";

  if (errorEmpty == true) {
    $("#service, #description, #file").addClass("input-error");

  }
  if (errorService == true) {
    $("#service").addClass("input-error");
  }
  if (errorDescription == true) {
    $("#description").addClass("input-error");
  }
  if (errorImage == true) {
    $("#file").addClass("input-error");
  }

  if (errorEmpty == false && errorService == false && errorDescription == false && errorImage == false) {
    $("#service, #description, #file").val("");
    //hide form
    $(".connection-wrapper").hide();
    $('#backPage').removeClass('d-none')
  }
</script>