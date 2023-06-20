<?php
require_once __DIR__."/../templates/header-admin.php";
?>
<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="#">Revenir liste</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h2 class="header-titles">Ajouter Service</h2>
    <div class="connection-wrapper">
      <form action="">
        <div class="connection-form">
          <div class="form-group">
            <label for="service">Service</label>
            <input type="text" name="service" id="service">
          </div>
          <div class="form-group">
            <label for="service-description">Description</label>
            <textarea name="service-description" id="service-description" class="service-description" cols="30"
              rows="10"></textarea>
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" value="add-service" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php
require_once __DIR__."/../templates/footer-admin.php";
?>