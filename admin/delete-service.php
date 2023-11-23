<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";



$service = false;
$errors = [];
$messages = [];
if (isset($_GET["id"])) {
  $service = getServicesById($pdo, $_GET["id"]);
}

if ($service) {
  if (deleteService($pdo, $_GET["id"])) {
    $messages[] = "Le service a bien été supprimé";
  } else {
    $errors[] = "Une erreur s'est produite lors de la suppression";
  }
} else {
  $errors[] = "Le service n'existe pas";
}
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-employes.php">Revenir liste service</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection ">

    <!-- messages  -->

    <div id="form-message" class="my-3 mt-3 d-flex justify-content-center">

      <?php foreach ($messages as $message) { ?>
        <div class="alert alert-success m-0" role="alert">
          <?= $message; ?>
        </div>
      <?php } ?>

      <?php foreach ($errors as $error) { ?>
        <div class="alert alert-danger m-0" role="alert">
          <?= $error; ?>
        </div>
      <?php } ?>
    </div>
    <div class="w-100 text-center mt-5">
      <a href="javascript:history.back(1)" class="btn-fill ">Retourner liste services</a>
    </div>
  </section>
</div>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>