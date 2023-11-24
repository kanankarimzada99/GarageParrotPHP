<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";

$_SESSION['token'] = bin2hex(random_bytes(30));

?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-voitures.php">Revenir liste voitures</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Ajouter voiture</h1>


    <!-- messages  -->
    <div id="form-message" class="my-3 mt-3 mx-2 d-flex flex-wrap justify-content-center"></div>

    <div class="w-100 text-center mt-4 d-none" id="backPage">
      <a href="javascript:history.back(1)" class="btn-fill ">Retourner liste voiture</a>
    </div>

    <div class="connection-wrapper">
      <form id="addCar" method="POST" enctype="multipart/form-data">
        <div class="connection-form add-car">

          <div class="car-model">
            <div class="car-model-bottom">
              <div class="form-group">
                <label for="code">Code</label>
                <input type="text" name="code" id="code" minlength="6" maxlength="6" placeholder="BMW033" autocomplete="off">
                <span class="error" id="code_err"></span>
              </div>
              <div class="car-model-bottom">
                <div class="form-group">
                  <label for="brand">Marque</label>
                  <input type="text" name="brand" id="brand" maxlength="15" placeholder="Tesla" autocomplete="off">
                  <span class="error" id="brand_err"></span>
                </div>
                <div class="form-group">
                  <label for="model">Modèle</label>
                  <input type="text" name="model" id="model" minlength="3" maxlength="15" placeholder="Max 5" autocomplete="off">
                  <span class="error" id="model_err"></span>
                </div>
              </div>
            </div>

            <div class="car-description">
              <!-- LEFT SIDE  -->
              <div class="car-description-left">
                <div class="form-group">
                  <label for="year">Année</label>
                  <input type="text" name="year" id="year" minlength="4" maxlength="4" placeholder="2002" autocomplete="off">
                  <span class="error" id="year_err"></span>

                </div>
                <div class="form-group">
                  <label for="kilometer">Kilométrage</label>
                  <input type="text" name="kilometer" id="kilometer" minlength="3" maxlength="6" placeholder="92233" autocomplete="off">
                  <span class="error" id="kilometer_err"></span>
                </div>
                <div class="form-group">
                  <label for="gearbox">Boîte de vitesses</label>
                  <input type="text" name="gearbox" id="gearbox" minlength="6" maxlength="12" placeholder="manuelle" autocomplete="off">
                  <span class="error" id="gearbox_err"></span>
                </div>
                <div class="form-group">
                  <label for="doors">Numéro de portes</label>
                  <input type="text" name="doors" id="doors" minlength="1" maxlength="1" placeholder="2" autocomplete="off">
                  <span class="error" id="doors_err"></span>
                </div>
              </div>

              <!-- RIGHT SIDE  -->
              <div class="car-description-right">
                <div class="form-group">
                  <label for="price">Prix</label>
                  <input type="text" name="price" id="price" minlength="4" maxlength="6" placeholder="12768" autocomplete="off">
                  <span class="error" id="price_err"></span>
                </div>
                <div class="form-group">
                  <label for="color">Couleur</label>
                  <input type="text" name="color" id="color" minlength="3" maxlength="15" placeholder="rouge" autocomplete="off">
                  <span class="error" id="color_err"></span>
                </div>
                <div class="form-group">
                  <label for="fuel">Carburant</label>
                  <input type="text" name="fuel" id="fuel" minlength="6" maxlength="12" placeholder="életrique" autocomplete="off">
                  <span class="error" id="fuel_err"></span>
                </div>
                <div class="form-group">
                  <label for="co2">CO2</label>
                  <input type="text" name="co2" id="co2" minlength="1" maxlength="4" placeholder="123" autocomplete="off">
                  <span class="error" id="co2_err"></span>
                </div>
                <div class="form-group">
                  <label for="images">Choisissez image(s):</label>
                  <input type="file" name="images[]" id="images" multiple accept=".jpeg, .jpg, .png, .webp" required autocomplete="off">
                  <span class="error" id="image_err"> </span>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
          <div class="form-btn">
            <button type="button" id="submitbtn" class="btn-fill">Ajouter</button>
          </div>
      </form>
    </div>

  </section>

</div>

<script src="../assets/scripts/validationCarForm.js"></script>
<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>