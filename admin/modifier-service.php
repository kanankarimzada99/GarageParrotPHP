<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";
$errors = '';


$id = null;

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];

  $service = getServicesById($pdo, $id);

  $_SESSION['service'] = $service;

  if ($service === false) {
    $errors =  "<div class='alert alert-danger m-0' role='alert'>Cette service n'existe pas</div>";
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
    <h1 class="header-titles">Modifier Service</h1>

    <!-- if service doesnt exist  -->
    <?php if ($service) : ?>

      <!-- messages  -->
      <div id="form-message" class="my-3 mt-3 d-flex justify-content-center"></div>

      <div class="connection-wrapper">
        <form id="modifyService" method="POST" enctype="multipart/form-data">
          <div class="connection-form">
            <div class="form-group">
              <label for="service">Service</label>
              <input type="text" name="service" id="service" minlength="15" maxlength="30" placeholder="Reparation motor" autocomplete="off" value="<?= htmlspecialchars($service['service']); ?>">
              <span class="error" id="service_err"></span>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" id="description" class="service-description" cols="30" rows="5" minlength="50" maxlength="150"><?= htmlspecialchars($service['description']); ?></textarea>
              <span class="error" id="description_err"></span>
            </div>
            <div id="imgContainer">
              <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars($service['image'] ?? "") ?>" alt="<?= $service['service'] ?>">
              <input type="hidden" name="image" value="<?= htmlspecialchars($service['image'] ?? ""); ?>">
              <div class="checkboxImage">
                <input type="checkbox" id="imgCar" name="imgCar" value="0" class="col-2 ">
                <label for="imgCar" class="mx-2">Modifier image?</label>
              </div>
            </div>

            <div>
              <div class="inputFile mt-2">
                <label for="file">Modifier image</label>
                <input type="file" name="file" id="file" multiple accept=".jpeg, .jpg, .png, .webp">
                <span class="error" id="image_err"> </span>
              </div>
            </div>
          </div>
          <div class="form-btn mt-2">
            <button type="button" id="submitbtn" class="btn-fill">Modifier</button>
          </div>
        </form>
      </div>
  </section>
</div>
<!-- show / hide upload button  -->
<script>
  let changeImg = document.getElementById("imgCar");
  let inputFile = document.querySelector(".inputFile");

  const checkClick = () => {
    if (inputFile.style.display === "block") {
      inputFile.style.display = "none";
    } else {
      inputFile.style.display = "block";
    }
  }

  changeImg.addEventListener('change', checkClick)
</script>

<script src="../assets/scripts/modifyServiceForm.js"></script>

<?php else : ?>
  <div id="form-message" class="d-flex justify-content-center">
    <div class='d-flex justify-content-center  alert alert-danger mt-5 mb-3 mx-auto' role='alert'>Ce service n'existe
      pas</div>
  </div>

  <div class="go-back-page my-3 d-flex justify-content-center">
    <a href="javascript:history.back(1)" class="btn-wire mb-5">Retour page précédante</a>
  </div>
<?php endif ?>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>