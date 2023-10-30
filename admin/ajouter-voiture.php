<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/templates/header-admin.php";


?>

<!-- <script>
  $(document).ready(function() {
    $('#addCar').submit(function(e) {
      e.preventDefault()
      $("#message-error").removeClass("d-none");
      $("#message-error").empty();

      let code = $("#code").val();
      let brand = $("#brand").val();
      let model = $("#model").val();
      let year = $("#year").val();
      let kilometer = $("#kilometer").val();
      let gearbox = $("#gearbox").val();
      let doors = $("#doors").val();
      let price = $("#price").val();
      let color = $("#color").val();
      let fuel = $("#fuel").val();
      let co2 = $("#co2").val();
      let fileInput = $("#image")[0].files[0];

      //regexs
      let codePattern = new RegExp("^[A-Za-z]{3}\\d{3}$")
      let brandPattern = new RegExp("^[a-zA-Z\\s+]{3,15}$")
      let modelPattern = new RegExp("^[a-zA-Z0-9 ]{3,15}$")
      let yearPattern = new RegExp("^[0-9]*$")
      let kilometerPattern = new RegExp("^[0-9^[1-9]\\d{5}")
      let gearboxPattern = new RegExp("^[a-zA-ZÀ-ÿ-]{6,12}$")
      let doorsPattern = new RegExp("^[0-9]{0,1}$")
      let pricePattern = new RegExp("^\\D*(?:\\d\\D*){4,}$")
      let colorPattern = new RegExp("^[a-zA-ZÀ-ÿ\\s]{3,20}$")
      let fuelPattern = new RegExp("^[a-zA-ZÀ-ÿ-]{6,12}$")
      let co2Pattern = new RegExp("^[0-9]{0,4}$")

      //get today date
      let today = new Date();
      //today less one year
      let LessOneYear = today.getFullYear()
      let lessTwentyYear = today.getFullYear() - 20


      let valid = true;

      if (!fileInput && !code && !brand && !model && !year && !kilometer && !gearbox && !doors && !price && !
        color && !fuel && !co2) {
        valid = false

        $("#code").addClass("input-error");
        $("#brand").addClass("input-error");
        $("#model").addClass("input-error");
        $("#year").addClass("input-error");
        $("#kilometer").addClass("input-error");
        $("#gearbox").addClass("input-error");
        $("#doors").addClass("input-error");
        $("#price").addClass("input-error");
        $("#color").addClass("input-error");
        $("#fuel").addClass("input-error");
        $("#co2").addClass("input-error");
        $("#image").addClass("input-error");
        $("#message-error").text("Vous devez remplir tous les champs");
        $("#message-error").removeClass("d-none")
        return;

      } else {
        $("#code").removeClass("input-error");
        $("#brand").removeClass("input-error");
        $("#model").removeClass("input-error");
        $("#year").removeClass("input-error");
        $("#kilometer").removeClass("input-error");
        $("#gearbox").removeClass("input-error");
        $("#doors").removeClass("input-error");
        $("#price").removeClass("input-error");
        $("#color").removeClass("input-error");
        $("#fuel").removeClass("input-error");
        $("#co2").removeClass("input-error");
        $("#image").removeClass("input-error");
        $("#message-error").removeClass("d-none")
      }

      //validate inputs
      if (code.trim() === "") {
        valid = false;
        $("#code").addClass("input-error");
        $("#message-error").removeClass("d-none");
        $("#message-error").text('Le code est requis.');
        return;
      } else if (code != codePattern.exec(code)) {
        $('#code').addClass('input-error');
        $("#message-error").text(
          'Le code doit contenir uniquement 3 lettres et 3 chiffres.'
        );
        valid = false;
        return;
      } else if (brand.trim() === "") {
        valid = false;
        $("#brand").addClass("input-error");
        $("#message-error").removeClass("d-none");
        $("#message-error").text('Le brand est requis.');
        return;
      } else if (brand != brandPattern.exec(brand)) {
        $('#brand').addClass('input-error');
        $("#message-error").text(
          'La marque doit contenir uniquement des lettres et spaces et avoir une longueur maximale de 15 caractères.'
        );
        valid = false;
        return;
      } else if (model.trim() === "") {
        valid = false;
        $("#model").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('Le modèle est requis.')
        return
      } else if (model != modelPattern.exec(model)) {
        $('#model').addClass('input-error');
        $("#message-error").text(
          'Le modèle doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 25 caractères.'
        )
        valid = false;
        return
      } else if (year.trim() === "") {
        valid = false;
        $("#year").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text("L'anneé est requis.")
        return
      } else if (year != yearPattern.exec(year)) {
        $('#year').addClass('input-error');
        $("#message-error").text(
          "L'anneé doit contenir uniquement des chiffres et avoir une longueur de 4 caractères."
        )
        valid = false;
        return
      } else if (year >= LessOneYear || year <= lessTwentyYear) {
        $("#year").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text(
          "L'anneé doit être plus petit que l'année current et ne doit pas être plus petit que année moins 20 ans."
        )
        valid = false;
        return
      } else if (kilometer.trim() === "") {
        valid = false;
        $("#kilometer").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('La Kilométrage est requis.')
        return
      } else if (kilometer != kilometerPattern.exec(kilometer)) {
        $('#kilometer').addClass('input-error');
        $("#message-error").text(
          'La Kilométrage doit contenir uniquement des chiffres et avoir une longueur de 6 caractères.'
        )
        valid = false;
        return
      } else if (gearbox.trim() === "") {
        valid = false;
        $("#gearbox").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('La boîte de vitesses est requis.')
        return
      } else if (gearbox != gearboxPattern.exec(gearbox)) {
        $('#gearbox').addClass('input-error');
        $("#message-error").text(
          'La boîte de vitesses doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères.'
        )
        valid = false;
        return
      } else if (doors.trim() === "") {
        valid = false;
        $("#doors").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('Le numéro de portes est requis.')
        return
      } else if (doors != doorsPattern.exec(doors)) {
        $('#doors').addClass('input-error');
        $("#message-error").text(
          'Le numéro de portes doit contenir uniquement des chiffres et avoir une longueur maximale de 2 caractères.'
        )
        valid = false;
        return
      } else if (price.trim() === "") {
        valid = false;
        $("#price").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('Le prix est requis.')
        return
      } else if (price != pricePattern.exec(price)) {
        $('#price').addClass('input-error');
        $("#message-error").text(
          'Le prix doit contenir uniquement des chiffres et avoir une longueur minimum de 6 chiffres et maximale de 10 chiffres.'
        )
        valid = false;
        return
      } else if (color.trim() === "") {
        valid = false;
        $("#color").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('La couleur est requis.')
        return
      } else if (color != colorPattern.exec(color)) {
        $('#color').addClass('input-error');
        $("#message-error").text(
          'La couleur doit contenir uniquement des lettres et espaces et avoir une longueur maximale de 15 caractères.'
        )
        valid = false;
        return
      } else if (fuel.trim() === "") {
        valid = false;
        $("#fuel").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('Le carburant est requis.')
        return
      } else if (fuel != fuelPattern.exec(fuel)) {
        $('#fuel').addClass('input-error');
        $("#message-error").text(
          "Le carburant doit contenir uniquement des lettres et avoir une longueur maximale de 15 caractères."
        )
        valid = false;
        return
      } else if (co2.trim() === "") {
        valid = false;
        $("#co2").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text('Le CO2 est requis.')
        return
      } else if (co2 != co2Pattern.exec(co2)) {
        $('#co2').addClass('input-error');
        $("#message-error").text(
          "Le CO2 doit contenir uniquement des chiffres et avoir une longueur maximale de 3 caractères."
        )
        valid = false;
        return
      }

      //image validation
      if (!fileInput) {
        valid = false;
        $("#image").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text("L'image est requis.")
        return
      }

      $(fileInput).on("change", function() {
        if (this.files[0].size > 2000000) {
          valid = false;
          $("#image").addClass("input-error");
          $("#message-error").removeClass("d-none")
          $("#message-error").text("L'image ne peut pas depasser 2MG.")
          $(this).val('');
          return
        }
      });

      if (!fileInput.type.match('image/jpeg|image/jpg|image/png|image/webp')) {
        valid = false;
        $("#image").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text("Seulement jpg, jpeg, png ou webp sont accepté")
        return
      }

      let formData = new FormData(this);

      if (valid) {
        $("#message-error").addClass("d-none")
        $("#message-success").removeClass("d-none")
        $("#message-success").text("La voiture été bien sauvegardé")

        $.ajax({
          type: 'POST',
          url: 'ajouterVoitureForm.php',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            $('#addCar')[0].reset();
          },
          cache: false,
          contentType: false,
          processData: false
        });

        //hide form
        $(".connection-wrapper").hide();
        // hide message after 3 seconds
        setTimeout(function() {
          // $('.form-message').hide();
          window.location = '/admin/liste-voitures.php';
        }, 3000);

      } else {
        $('#message-error').removeClass('d-none')
        $('#message-error').text("La voiture n'été pas sauvegardé");
      }

    });
  });
</script> -->

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
    <div id="form-message" class="my-3 d-flex justify-content-center"></div>

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
                  <input type="text" name="kilometer" id="kilometer" minlength="6" maxlength="6" placeholder="92233" autocomplete="off">
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
                  <input type="text" name="color" id="color" minlength="5" maxlength="10" placeholder="rouge" autocomplete="off">
                  <span class="error" id="color_err"></span>
                </div>
                <div class="form-group">
                  <label for="fuel">Carburant</label>
                  <input type="text" name="fuel" id="fuel" minlength="5" maxlength="12" placeholder="életrique" autocomplete="off">
                  <span class="error" id="fuel_err"></span>
                </div>
                <div class="form-group">
                  <label for="co2">CO2</label>
                  <input type="text" name="co2" id="co2" minlength="1" maxlength="3" placeholder="123" autocomplete="off">
                  <span class="error" id="co2_err"></span>
                </div>
                <div class="form-group">
                  <label for="images">Voiture images:</label>
                  <input type="file" name="images[]" id="images" multiple accept=".jpeg, .jpg, .png, .webp" required>
                  <span class="error" id="image_err"> </span>
                </div>
              </div>
            </div>
          </div>
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