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


$id = null;
$errors = [];
$messages = [];
$formService = [
  'service' => '',
  'description' => ''
];



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //verify errors inside the form

  //to validate service
  if (empty($_POST['service'])) {
    $errors[] = "Le service est requis.";
  } elseif (!preg_match(_REGEX_SERVICE_, $_POST['service'])) {
    $errors[] = "Le service doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.";
  }
  //to validate description
  if (empty($_POST['service-description'])) {
    $errors[] = "La description est requis.";
  } elseif (!preg_match(_REGEX_DESCRIPTION_, $_POST['service-description'])) {
    $errors[] = "La description doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.";
  }


  $imageId = null;
  //verify if a file is sent
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image = $_FILES['image'];

    // get info about image
    $imageName = $image['name'];
    $imageTmpPath = $image['tmp_name'];

    //delete spaces into the name and make name file with lowercase letters
    $imageId = slugify(basename($_FILES['image']['name']));


    // generate uniq id to the image
    $imageId = uniqid() . '-' . $imageId;

    //regex to image format
    $fileExtensionPattern = '/\.(jpg|jpeg|png|webp)$/i';
    if (preg_match($fileExtensionPattern, $imageId)) {
      // move image to the uploads folder
      $imagePath = dirname(__DIR__) . _GARAGE_IMAGES_FOLDER_ . $imageId;
      move_uploaded_file($imageTmpPath, $imagePath);

      $messages[] = 'Votre image ete bien envoyé';
    } else {
      $errors[] = "Le format d'image n'est pas valide. Seulement jpg, jpeg, png ou webp sont permit.";
    }
  } else {
    $errors[] = 'Erro ao enviar a imagem.';
  }


  //put information from form to formEmployee
  $formService = [
    'service' => $_POST['service'],
    'description' => $_POST['service-description'],
    'image' =>  $imageId
  ];

  //if no errors we save all information
  if (!$errors) {

    //all data will be saved at saveEmployee function
    $res = saveService($pdo, $_POST["service"], $_POST["service-description"], $imageId, $id);

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
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
          <div class="connection-form">
            <div class="form-group">
              <label for="service">Service</label>
              <input type="text" name="service" id="service" minlength="5" maxlength="30" placeholder="Reparation motor" autocomplete="off" value=<?= htmlspecialchars($formService['service']); ?>>
            </div>
            <div class="form-group">
              <label for="service-description">Description</label>
              <textarea name="service-description" id="service-description" class="service-description" cols="30" rows="5" minlength="50" maxlength="150"><?= htmlspecialchars($formService['description']); ?></textarea>
            </div>
            <p class="form-group">
              <input type="file" name="image" id="image" hidden>
              <label for="image" class="btn-wire d-inline p-2">Choisissez une image de service</label>
            </p>

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