<?php
require_once __DIR__."/../templates/header-admin.php";
?>

<div class="wrapper">

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h2 class="header-titles">Modifier veícule</h2>
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
                <label for="car-number-doors">Numéro de portes</label>
                <input type="text" name="car-number-doors" id="car-number-doors">
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
                <label for="car-images">Insert image(s)</label>
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
require_once __DIR__."/../templates/footer-admin.php";
?>