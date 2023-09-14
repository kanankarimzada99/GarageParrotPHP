<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
//only admin has permission to visit this page
adminOnly();
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/templates/header-admin.php";
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
    <div id="message" class="alert alert-success mt-4 d-none" role="alert"></div>

    <div class="form-message">
      <div id="message-success" class="alert alert-success mt-4 d-none" role="alert">
      </div>

      <div id="message-error" class="alert alert-danger mt-4 d-none" role="alert">
      </div>
    </div>


    <div class=" connection-wrapper">
      <form id="addService.php" action='ajouterServiceForm.php' method="POST" enctype="multipart/form-data">
        <div class="connection-form">
          <div class="form-group">
            <label for="service">Service</label>
            <input type="text" name="service" id="service" minlength="5" maxlength="30" placeholder="Reparation motor"
              autocomplete="off">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="service-description" cols="30" rows="5" minlength="50"
              maxlength="150"></textarea>
          </div>
          <div class="form-group">
            <label for="image" class="btn btn-wire d-inline-flex px-2">Choisissez une image</label>
            <input class="form-control-file" type="file" name="image" id="image" accept=".jpeg, .jpg, .png, .webp"
              hidden>
          </div>

        </div>
        <div class="form-btn">
          <button type="submit" id="submit" value="add-service" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
</div>


<script>
$(document).ready(function() {
  $("#submit").click(function(event) {
    event.preventDefault();
    $("#message-error").removeClass("d-none");
    $("#message-error").empty();

    //get value inputs
    let service = $("#service").val();
    let description = $("#description").val();
    let fileInput = $("#image")[0].files[0];
    let submit = $("#submit").val();


    //regexs
    let servicePattern = new RegExp("^[a-zA-ZÀ-ÿ\-\s\p{P}][^0-9]{15,30}$")
    let descriptionPattern = new RegExp("^[a-zA-ZÀ-ÿ\-\s\p{P}][^0-9]{50,150}$")

    let valid = true;

    if (!fileInput && !service && !description) {
      valid = false


      //messages
      $("#service").addClass("input-error");
      $("#description").addClass("input-error");
      $("#image").addClass("input-error");
      $("#message-error").text("Vous devez remplir tous les champs");
      $("#message-error").removeClass("d-none")
      return;

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
      return;
    } else if (service != servicePattern.exec(service)) {
      $('#service').addClass('input-error');
      $("#message-error").text(
        'Le service doit contenir uniquement des lettres et chiffres et avoir une longueur maximale de 25 caractères.'
      );
      valid = false;
      return;
    } else if (description.trim() === "") {
      valid = false;
      $("#description").addClass("input-error");
      $("#message-error").removeClass("d-none");
      $("#message-error").text('La description est requis.');
      return;
    } else if (description != descriptionPattern.exec(description)) {
      $('#description').addClass('input-error');
      $("#message-error").text(
        'La description doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 150 caractères.'
      );
      valid = false;
      return;
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

    if (valid) {
      $("#message-error").addClass("d-none")
      $("#message-success").removeClass("d-none")
      $("#message-success").text("Le service été bien sauvegardé.")

      const formData = new FormData();
      formData.append("service", service);
      formData.append("description", description);
      formData.append("fileImg", fileInput);

      $.ajax({
        url: 'ajouterServiceForm.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
          $('#addService')[0].reset();
        },
        cache: false,
        contentType: false,
        processData: false
      })

    } else {
      $('#message-error').removeClass('d-none')
      $('#message-error').text("Le service n'été pas sauvegardé");
    }

  });
});
</script>
<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>