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
$fileName = null;

$regexService = '/^[a-zA-Z\s\p{P}]{5,25}$/u';
$regexDescription = '/^[a-zA-Z\s\p{P}]{5,250}$/u';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['user']['id'] = $id;

  $service = getServicesById($pdo, $id);

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

  // if (!preg_match('/[^\s]+(.*?).(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/', $_POST['image'])) {
  //   $errors[] = "Le format d'image n'est pas valide.";
  // }

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
    if (isset($_SESSION['user']['id'])) {
      //the id will be int
      $id = (int)$_SESSION['user']['id'];
    } else {
      $id = null;
    }

    //all data will be saved at saveEmployee function
    $id = $_SESSION['user']['id'];

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

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-services.php">Revenir liste services</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Modifier service</h1>

    <!-- messages  -->
    <?php foreach ($messages as $message) { ?>
    <div class="alert alert-success mt-4" role="alert">
      <?= $message; ?>
    </div>
    <?php } ?>

    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger mt-4" role="alert">
      <?= $error; ?>
    </div>

    <?php } ?>
    <?php if ($formService !== false) { ?>
    <div class="connection-wrapper">

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="connection-form">
          <div class="form-group">
            <label for="service">Service</label>
            <input type="text" name="service" id="service"
              value=<?= htmlspecialchars($service['service'] ?? $formService['service']) ; ?>>
          </div>
          <div class="form-group">
            <label for="service-description">Description</label>
            <textarea name="service-description" id="service-description" class="service-description" cols="30"
              rows="5"><?= htmlspecialchars($service['description'] ?? $formService['description']) ; ?></textarea>
          </div>

          <div class="form-group">
            <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars($service['image'] ?? $formService['image'])?>"
              alt="<?= $formService['service'] ?>" class="w-25">
            <!-- <label for="delete_image">Supprimer l'image</label>
          <input type="checkbox" name="delete_image" id="delete_image"> -->
            <input type="hidden" name="image"
              value="<?= htmlspecialchars($service['image'] ?? $formService['image']) ; ?>">
          </div>
          <p>
            <input type="file" name="file" id="file">
          </p>
        </div>
        <div class=" form-btn">
          <button type="submit" value="saveService" class="btn-fill">Modifier</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php } else { ?>
<div class="not-found">
  <!-- <h2 class="not-found-text">Employé non trouvé</h2> -->
  <div class="go-back-page">
    <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
  </div>
</div>
<?php } ?>

<?php
      require_once __DIR__ . "/templates/footer-admin.php";
?>