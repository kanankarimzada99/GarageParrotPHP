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
  header("location: /admin/liste-voitures.php");
}


$id=null;
$errors = [];
$messages = [];
$formService = [
  'service' => '',
  'description' => ''
];

//regex
$regexService = '/^[a-zA-Z0-9\s]{3,20}$/';
$regexDescription = '/^[a-zA-Z0-9\s]{3,250}$/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
  //verify errors inside the form

  //to validate service
  if (empty($_POST['service'])) {
    $errors[] = "Le service est requis.";
  } elseif (!preg_match($regexService, $_POST['service'])) {
    $errors[] = "Le service doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.";
  }
  //to validate description
  if (empty($_POST['service-description'])) {
    $errors[] = "La description est requis.";
  } elseif (!preg_match($regexDescription, $_POST['service-description'])) {
    $errors[] = "La description doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.";
  }

  //to verify image format
  if (!preg_match('/\.(jpg|jpeg|png|gif)$/', $_POST['image'])) {
    $errors[] = "Le format d'image n'est pas valide.";
  }

  $fileName = null;
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

        if (isset($_POST['image'])) {
          //delete old image if new one is uploaded
          unlink(dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $_POST['image']);
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

  //put information from form to formEmployee
  $formService = [
    'service' => $_POST['service'],
    'description' => $_POST['service-description'],
    'image' => $fileName
  ];

  //if no errors we save all information
  if (!$errors) {

    //all data will be saved at saveEmployee function
    $res = saveService($pdo, $_POST["service"], $_POST["service-description"], $_POST["image"], $id);

    if ($res) {
      $messages[] = "Le service a bien été sauvegardé";

      //all information at formService will be deleted
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
      <a href="/admin/liste-services.php">Revenir liste service</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Ajouter Service</h1>

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
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="connection-form">
          <div class="form-group">
            <label for="service">Service</label>
            <input type="text" name="service" id="service" value=<?= htmlspecialchars($formService['service']); ?>>
          </div>
          <div class="form-group">
            <label for="service-description">Description</label>
            <textarea name="service-description" id="service-description" class="service-description" cols="30"
              rows="5"><?= htmlspecialchars($formService['description']); ?></textarea>
          </div>
          <div class="form-group">
            <label for="image">Choisissez une image de service:</label>
            <input type="file" name="image" id="image">
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" value="add-service" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>

<?php } else { ?>
<div class="not-found">
  <!-- <h1 class="not-found-text">Employé non trouvé</h1> -->
  <div class="go-back-page">
    <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
  </div>
</div>
<?php } ?>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>