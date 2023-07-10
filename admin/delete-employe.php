<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/employees.php";
require_once __DIR__ . "/templates/header-admin.php";

//employees don't have permission to visit this page
if ($_SESSION['user']['role'] === 'employee') {
  header("location: /admin/liste-voitures.php");
}

$employee = false;
$errors = [];
$messages = [];
if (isset($_GET["id"])){
  $employee = getEmployeesById($pdo, $_GET["id"]);
}

if($employee){
  if(deleteEmployee($pdo, $_GET["id"])){
    $messages[]= "L'employé a bien été supprimé";
  }else {
    $errors[]= "Une erreur s'est produite lors de la suppression";
  }
}else {
  $errors[] = "L'employé n'existe pas";
}
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-employes.php">Revenir liste employé</a>
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