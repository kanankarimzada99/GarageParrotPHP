<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";

//session token
$_SESSION['token'] = bin2hex(random_bytes(30));

$id = null;


?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-avis.php">Revenir liste avis</a>
    </div>
  </div>

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Ajouter avis client</h1>

    <!-- messages  -->
    <div id="form-message" class="my-3 mt-3 d-flex flex-wrap justify-content-center"></div>

    <div class="w-100 text-center mt-4 d-none" id="backPage">
      <a href="javascript:history.back(1)" class="btn-fill ">Retourner liste voiture</a>
    </div>


    <div class="connection-wrapper">

      <form method="POST" id="addReview">

        <div class="connection-form">
          <div class="form-group">
            <label for="client">Nom client</label>
            <input type="text" name="client" id="client" minlength="5" maxlength="45" placeholder="Dupont Jean-Charles" autocomplete="off">
            <span class="error" id="client_err"> </span>
          </div>
          <div class="form-group">
            <label for="comment">Commentaire</label>
            <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="15" maxlength="250"> </textarea>
            <span class="error" id="comment_err"> </span>
          </div>

          <div class="form-group">
            <label for="note">Note client</label>
            <select name="note" id="note" class="form-control note">
              <option value="">Choisissez une note</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <span class="error" id="note_err"> </span>
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

<script src="../assets/scripts/validationReviewForm.js"></script>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>