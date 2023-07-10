<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";

$reviews = false;
$errors = [];
$messages = [];
if (isset($_GET["id"])){
  $reviews = getReviewsById($pdo, $_GET["id"]);
}

if($reviews){
  if(deleteReview($pdo, $_GET["id"])){
    $messages[]= "L'avis a bien été supprimé";
  }else {
    $errors[]= "Une erreur s'est produite lors de la suppression";
  }
}else {
  $errors[] = "L'avis n'existe pas";
}
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-avis.php">Revenir liste avis</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection ">

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
    <div class="w-100 text-center mt-5">
      <a href="javascript:history.back(1)" class="btn-fill ">Page precedante</a>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>

<?php
      require_once __DIR__ . "/templates/footer-admin.php";
?>