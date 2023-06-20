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
    <h2 class="header-titles">Ajouter un avis de client</h2>
    <div class="connection-wrapper">

      <form action="">
        <div class="connection-form">
          <div class="form-group">
            <label for="review-name">Nom client</label>
            <input type="text" name="review-name" id="review-name">
          </div>
          <div class="form-group">
            <label for="review-comment">Commentaire</label>
            <textarea name="review-comment" id="review-comment" class="service-description" cols="30"
              rows="5"></textarea>
          </div>

          <div class="form-group">
            <label for="review-note">Note client</label>
            <select name="review-note" id="review-note">
              <option value="">--Choisissez une note--</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
          </div>
        </div>
        <div class="form-btn">
          <button type="submit" value="add-review" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
  <!-- END CONTACT  -->
</div>
<?php
require_once __DIR__."/../templates/footer-admin.php";
?>