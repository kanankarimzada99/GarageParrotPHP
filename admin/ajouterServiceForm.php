<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";


$id = null;

//for security inputs
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$service = $description = '';
$response = array(
  'status' => 0,
  'message' => 'Form submission failled'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



  $service = test_input($_POST['service']);
  $description = test_input($_POST['description']);
  $file = $_FILES['fileImg'];


  $imageId = null;
  $imagePath = null;
  $error = false;
  //verify if a file is sent

  if (isset($_FILES['fileImg']) && $_FILES['fileImg']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['fileImg'];

    // get info about image
    $imageName = $image['name'];
    $imageTmpPath = $image['tmp_name'];

    //delete spaces into the name and make name file with lowercase letters
    $imageId = slugify(basename($_FILES['fileImg']['name']));


    // generate uniq id to the image
    $imageId = uniqid() . '-' . $imageId;

    //regex to image format
    $fileExtensionPattern = '/\.(jpg|jpeg|png|webp)$/i';
    if (preg_match($fileExtensionPattern, $imageId)) {
      // move image to the uploads folder
      $imagePath = dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $imageId;
      move_uploaded_file($imageTmpPath, $imagePath);
      $response['message'] = "Votre image ete bien envoyé";
    } else {

      $response['message'] = "Le format d'image n'est pas valide. Seulement jpg, jpeg, png ou webp sont permit.";
      exit();
    }
  } else {
    $response['message'] = "Une erreur s'est produite durant l'envoi.";
    echo json_encode($response);
    exit();
  }

  $res = saveService($pdo, $service, $description, $imageId, $id);

  if ($res) {

    $response['message'] = "Le service a bien été sauvegardé.";
    echo json_encode($response);
  } else {
    $response['message'] = "Le service n'a pas été sauvegardé.";
    echo json_encode($response);

    exit();
  }
}
echo json_encode($response);
