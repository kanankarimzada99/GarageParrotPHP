<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";
$errors = '';
//only admin has permission to visit this page
adminOnly();

$formService = [
  'service' => '',
  'description' => ''
];
$id = null;

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $service = getServicesById($pdo, $id);

  // var_dump($service);

  $_SESSION['service'] = $service;

  if ($service === false) {
    $errors =  "<div class='alert alert-danger m-0' role='alert'>Cette service n'existe pas</div>";
  }
}


// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//   $formService = [
//     'service' => $_POST['service'],
//     'description' => $_POST['description'],
//   ];
// }

?>

<!-- <script>
$(document).ready(function() {
  $('#modifyService').submit(function(e) {
    e.preventDefault()
    $("#message-error").removeClass("d-none");
    $("#message-error").empty();

    var service = $('#service').val();
    var description = $('#description').val();
    var file = $('#file')[0].files[0];


    //regexs
    var servicePattern = new RegExp("^[a-zA-ZÀ-ÿ\-\s\p{P}][^0-9]{15,30}$")
    var descriptionPattern = new RegExp("^[a-zA-ZÀ-ÿ\-\s\p{P}][^0-9]{50,150}$")

    var valid = true;

    if (!service && !description && !file) {
      valid = false

      $("#service").addClass("input-error");
      $("#description").addClass("input-error");
      $("#image").addClass("input-error");
      $("#message-error").removeClass("d-none")
      $("#message-error").text("Vous devez remplir tous les champs");
      return false;

    } else {
      $("#service").removeClass("input-error");
      $("#description").removeClass("input-error");
      $("#image").removeClass("input-error");
      $("#message-error").removeClass("d-none")
    }

    //validate inputs
    if (service.trim() === "") {
      valid = false;
      $("#service").addClass("input-error");
      $("#message-error").removeClass("d-none");
      $("#message-error").text('Le service est requis.');
      return false;
    } else if (service != servicePattern.exec(service)) {
      $('#service').addClass('input-error');
      $("#message-error").text(
        'Le service doit contenir uniquement des lettres. Minimum 15, maximum 30 caractères.'
      );
      valid = false;
      return false;
    } else if (description.trim() === "") {
      valid = false;
      $("#description").addClass("input-error");
      $("#message-error").removeClass("d-none");
      $("#message-error").text('La description est requis.');
      return false;
    } else if (description != descriptionPattern.exec(description)) {
      $('#description').addClass('input-error');
      $("#message-error").text(
        'La description doit avoir un longueur minimale de 50 et maximale de 150 caractères.'
      );
      valid = false;
      return false;

    }

    if ($('#chkbox').is(':checked')) {
      //image validation
      if (!file) {
        valid = false;
        $("#image").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text("L'image est requis.")
        return
      }

      $(file).on("change", function() {
        if (this.files[0].size > 2000000) {
          valid = false;
          $("#image").addClass("input-error");
          $("#message-error").removeClass("d-none")
          $("#message-error").text("L'image ne peut pas depasser 2MG.")
          $(this).val('');
          return
        }
      });

      if (!file.type.match('image/jpeg|image/jpg|image/png|image/webp')) {
        valid = false;
        $("#image").addClass("input-error");
        $("#message-error").removeClass("d-none")
        $("#message-error").text("Seulement jpg, jpeg, png ou webp sont accepté")
        return
      }
    }




    if (valid) {
      $("#message-error").addClass("d-none")
      $("#message-success").removeClass("d-none")
      $("#message-success").text("Le service a été bien sauvegardé")

      let formData = new FormData(this);


      $.ajax({
        url: 'modifierServiceForm.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // Clear form fields
          $('#service').val('');
          $('#description').val('');
          $('#file').val('');

          // Display success message
          $('#message').text('Le service a été bien sauvegardé');
        },
        error: function(xhr, status, error) {
          // Display error message
          $('#message').text('Une erreur se produit. Essayer plus tard.');
        }
      });

      //hide form
      $(".connection-wrapper").hide();
      // hide message after 3 seconds
      setTimeout(function() {
        // $('.form-message').hide();
        window.location = '/admin/liste-services.php';

      }, 3000);

    } else {
      $('.form-message-danger').removeClass('d-none')
      $('.form-message-success').text("Le service n'été pas sauvegardé");
    }

  });
});
</script> -->

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
    <div id="form-message" class="my-3 d-flex justify-content-center"></div>

    <!-- messages  -->
    <!-- <div class="form-message">
      <?= $errors; ?>
    </div>

    <div id="message" class="alert alert-success mt-4 d-none" role="alert"></div>

    <div class="form-message">
      <div id="message-success" class="alert alert-success mt-4 d-none" role="alert">
      </div>

      <div id="message-error" class="alert alert-danger mt-4 d-none" role="alert">
      </div>
    </div> -->

    <div class="connection-wrapper">
      <form id="modifyService" method="POST" enctype="multipart/form-data">
        <div class="connection-form">
          <div class="form-group">
            <label for="service">Service</label>
            <input type="text" name="service" id="service" minlength="5" maxlength="30" placeholder="Reparation motor"
              autocomplete="off" value="<?= htmlspecialchars($service['service'] ?? $formService['service']); ?>">
            <span class="error" id="service_err"></span>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="service-description" cols="30" rows="5" minlength="50"
              maxlength="150"><?= htmlspecialchars($service['description'] ?? $formService['description']); ?></textarea>
            <span class="error" id="description_err"></span>
          </div>
          <div class="form-group" id="imgContainer">
            <img src="<?= _GARAGE_IMAGES_FOLDER_ . htmlspecialchars($service['image'] ?? "") ?>"
              alt="<?= $service['service'] ?>">
            <input type="hidden" name="image" value="<?= htmlspecialchars($service['image'] ?? ""); ?>">
            <!-- <div class="form-group my-3">
              <input type="checkbox" id="chkbox" name="chkbox" value="0" class="col-2">
              <label for="chkbox">Cliquez ici pour changer d'image</label>
              <p class="inputFile my-2">
                <input type="file" name="file" id="file" hidden>
                <label for="file" class="btn-wire d-inline p-2  ">Modifier l'image</label>
              </p>
            </div> -->
          </div>
          <div class="form-group d-flex justify-content-start">

            <div class="d-flex align-items-center w-25">
              <input type="checkbox" id="imgCar" name="imgCar" value="0" class="col-2 ">
              <label for="imgCar" class="mx-2">Modifier image?</label>
            </div>
          </div>
          <div class="form-group">
            <div class="inputFile">
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

<!-- <script>
  let changeImg = document.getElementById("chkbox");
  let inputFile = document.querySelector(".inputFile");
  let submitButton = document.getElementById('submit')

  let mainDiv = document.getElementById('connection'),
    childDiv = mainDiv.getElementsByTagName('div')[0];

  const checkClick = () => {
    if (inputFile.style.display === "block") {
      inputFile.style.display = "none";
    } else {
      inputFile.style.display = "block";
    }
  }
  if (changeImg !== null) {
    changeImg.addEventListener('change', checkClick)
  }
</script> -->