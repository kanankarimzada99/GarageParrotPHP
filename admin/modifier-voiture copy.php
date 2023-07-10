<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";



//employees don't have permission to visit this page
if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-veicules.php");
}

$errors = [];
$messages = [];
$formService = [
  'service' => '',
  'description' => '',
  'image' => ''
];
$id = null;
$regexService = '/^[a-zA-Z\s\p{P}]{5,25}$/u';
$regexDescription = '/^[a-zA-Z\s\p{P}]{5,250}$/u';

$fileName = null;



if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['user']['id'] = $id;



  $service = getServicesById($pdo, $_GET['id']);



  if ($service === false) {
    $errors[] = "Cet service n'existe pas";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //to validate service
  if (empty($_POST["service"])) {
    $errors[] = "Le service est requis.";
  } elseif (!preg_match($regexService, $_POST["service"])) {
    $errors[] = "Le service doit contenir uniquement des lettres et avoir une longueur maximale de 25 caractères.";
  }
  //to validate description
  if (empty($_POST["service-description"])) {
    $errors[] = "La description du service est requis.";
  } elseif (!preg_match($regexDescription, $_POST["service-description"])) {
    $errors[] = "La description doit contenir uniquement des lettres et avoir une longueur maximale de 250 caractères.";
  }



  //verify if a file is sent
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
  
          // $service = getServicesById($pdo, $_SESSION['service']['id']);
  

          if(file_exists(dirname(__DIR__) . _GARAGE_UPLOADS_. $_FILES['file']['name'])){
            //delete old image if new one is uploaded
          unlink(dirname(__DIR__) . _GARAGE_UPLOADS_ . $_FILES['file']['name']);
          }else{
           $messages[]= "image remplace avec success";
          }
          
         
        }
      } else {
        $errors[] = "Le fichier n'a pas été uploadé";
      }
    } else {
      $errors[] = "Le fichier doit être une image";
    }
  } else {
    //if any image was sent
    if (isset($_GET['id'])) {
      // if (isset($_POST['delete_image'])) {
      //   // delete image if checkbox is checked
      //   unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_POST['image']);
      // } 
      // else {
        $fileName = $_POST['image'];
      // }
    }
  }
  
  //to validate service
  if (empty($_POST['service'])){
    $errors[] = "Le services est requis.";
  }elseif(!preg_match($regexService, $_POST['service'])){
    $errors[] = "Le service doit contenir uniquement des lettres et chiffres avoir une longueur maximale de 20 caractères.";
  }
  
  //to validate description
  if(empty($_POST['service-description'])){
    $errors[] = "La description est requis.";
  }elseif(!preg_match($regexDescription, $_POST['service-description'])){
    $errors[]="La description doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 200 caractères.";
  }
  //to validate image
  if(empty($_FILES['file']['name'])){
    $errors[] = "L'image pour le service est requis.";
  }
  
  





  $formService = [
    'service' => $_POST['service'],
    'description' => $_POST['service-description'],
    'image' => $_POST['image']
  ];



  //if no errors we save all information
  if (!$errors) {
    if (isset($_SESSION['service']['id'])) {
      //the id will be int
      $id = (int)$_SESSION['service']['id'];
    } else {
      $id = null;
    }

    //all data will be saved at saveEmployee function
    $id = $_SESSION['service']['id'];

    $res = saveService($pdo, $_POST["service"], $_POST["service-description"], $fileName, $id);



    if ($res) {
      $messages[] = "Le service a bien été sauvegardé";

      //all information at formEmployee will be deleted
      if (!isset($_GET["id"])) {
        $formService = [
          'service' => '',
          'description' => '',
          'image' => ''
        ];
      } else {
        $errors[] = "Le service n'a pas été sauvegardé";
      }
    }
  }
}




?>

<div class="wrapper">

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Modifier voiture</h1>
    <div class="connection-wrapper">

      <form action="" enctype="multipart/form-data">
        <div class="connection-form add-car">

          <div class="car-model">

            <!-- LEFT SIDE  -->
            <div class="car-model-top">
              <div class="form-group">
                <label for="car-code">Code</label>
                <input type="text" name="car-code" id="car-code">
              </div>
              <div class="form-group">
                <label for="car-title">titre</label>
                <input type="text" name="car-title" id="car-title">
              </div>
            </div>

            <!-- RIGHT SIDE  -->
            <div class="car-model-bottom">
              <div class="form-group">
                <label for="car-brand">Marque</label>
                <input type="text" name="car-brand" id="car-brand">
              </div>
              <div class="form-group">
                <label for="car-model">Modèle</label>
                <input type="text" name="car-model" id="car-model">
              </div>
            </div>
          </div>

          <div class="car-description">

            <!-- LEFT SIDE  -->
            <div class="car-description-left">
              <div class="form-group">
                <label for="car-year">Année</label>
                <input type="text" name="car-year" id="car-year">
              </div>
              <div class="form-group">
                <label for="car-kilometer">Kilométrage</label>
                <input type="text" name="car-kilometer" id="car-kilometer">
              </div>
              <div class="form-group">
                <label for="car-gearbox">Boîte de vitesse</label>
                <input type="text" name="car-gearbox" id="car-gearbox">
              </div>
              <div class="form-group">
                <label for="car-doors">Numéro de portes</label>
                <input type="text" name="car-doors" id="car-doors">
              </div>
            </div>

            <!-- RIGHT SIDE  -->
            <div class="car-description-right">
              <div class="form-group">
                <label for="car-price">Prix</label>
                <input type="text" name="car-price" id="car-price">
              </div>
              <div class="form-group">
                <label for="car-color">Couleur</label>
                <input type="text" name="car-color" id="car-color">
              </div>
              <div class="form-group">
                <label for="car-fuel">Carburant</label>
                <input type="text" name="car-fuel" id="car-fuel">
              </div>
              <div class="form-group">
                <label for="car-images">Choisissez une image de voiture:</label>
                <input type="file" id="car-images" multiple>
              </div>
            </div>
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" value="modify-car" class="btn-fill">Modifier</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php
require_once __DIR__."/templates/footer-admin.php";
?>