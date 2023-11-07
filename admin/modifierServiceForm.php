<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
    echo  "<div class='alert alert-danger d-inline' role='alert'>Vous devez remplir tous les champs.</div>";
    $errorEmpty = true;
  } elseif (!preg_match(_REGEX_SERVICE_, $service)) {
    echo   "<div class='alert alert-danger d-inline' role='alert'>Le service doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.</div>";
    $errorService = true;
  } elseif (!preg_match(_REGEX_DESCRIPTION_, $description)) {
    echo   "<div class='alert alert-danger d-inline' role='alert'>La description doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.</div>";
    $errorDescription = true;
  }

  //to validate image
  if (isset($_POST['imgCar'])) {
    if (empty($_FILES['file']['name'])) {
      echo "<div class='alert alert-danger d-inline' role='alert'>L'image pour le service est requis.</div>";
    } else {
      //verify if a file is sent
      // Handle image uploads
      if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {

        $sizeImage = getimagesize($_FILES['file']['tmp_name']);
        if ($sizeImage !== false) {

          //delete spaces into the name and make name file with lowercase letters
          $fileName = slugify(basename($_FILES['file']['name']));

          //generate unique ID for a file
          $fileName = uniqid() . '-' . $fileName;

          //move file image into new location (uploads images folder)  

          if (move_uploaded_file($_FILES['file']['tmp_name'], dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $fileName)) {

            if (isset($_FILES['file']['name'])) {

              if (file_exists(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name'])) {
                //delete old image if new one is uploaded
                unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_FILES['file']['name']);
              } else {
                echo '<div class="alert alert-success d-inline" role="alert">image sauvegardé avec success</div>';
              }
            }
            // $resImages = saveCarImages($pdo, $product_id, $image_path);
          } else {
            echo '<div class="alert alert-danger d-inline" role="alert">Le fichier n\'a pas été uploadé</div>';
            $errorImage = true;
          }
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
      echo  "<div class='alert alert-success d-inline' role='alert'>Le service a bien été sauvegardé.</div>";

      $errorImage = false;
      $errorEmpty = false;
      $errorService = false;
      $errorDescription = false;
      $errorImage = false;

      //empty session service
      unset($_SESSION['service']);
    } else {
      echo  "<div class='alert alert-success d-inline' role='alert'>Le service a bien été sauvegardé.</div>";
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
    // hide message after 3 seconds
    setTimeout(function() {
      window.location = '/admin/liste-services.php';
    }, 3000); // <-- time in milliseconds
  }
</script>