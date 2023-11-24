<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";


$_SESSION['token'] = bin2hex(random_bytes(30));
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
    <div id="form-message" class="my-3 mt-3 d-flex flex-wrap justify-content-center"></div>


    <div class="w-100 text-center mt-4 d-none" id="backPage">
      <a href="javascript:history.back(1)" class="btn-fill ">Retourner liste services</a>
    </div>

    <div class=" connection-wrapper">
      <form method="POST" id="addService" enctype="multipart/form-data">
        <div class="connection-form">
          <div class="form-group">
            <label for="service">Service</label>
            <input type="text" name="service" id="service" minlength="15" maxlength="30" placeholder="Reparation motor" autocomplete="off">
            <span class="error" id="service_err"> </span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="service-description" cols="30" rows="5" minlength="50" maxlength="150"></textarea>
            <span class="error" id="description_err"> </span>
          </div>
          <div class="form-group">
            <label for="image">Choisissez une image</label>
            <input class="form-control-file" type="file" name="image" id="image" accept=".jpeg, .jpg, .png, .webp">
            <span class="error" id="image_err"> </span>
          </div>
          <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
          <div class="form-btn">
            <button type="button" id="submitbtn" class="btn-fill">Ajouter</button>
          </div>
      </form>
    </div>
  </section>
</div>

<script src="../assets/scripts/validationServiceForm.js"></script>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>