<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";

$_SESSION['token'] = bin2hex(random_bytes(30));

$errors = '';

$id = null;

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $_SESSION['review']['id'] = $id;

  $review = getReviewsById($pdo, $id);

  if ($review === false) {
    $errors =  "<div class='alert alert-danger m-0' role='alert'>Cette avis n'existe pas</div>";
  }
}
?>


<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/admin/liste-avis.php">Revenir liste avis</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="connection sections" id="connection">
    <h1 class="header-titles">Modifier avis client</h1>

    <?php if ($review) : ?>

      <!-- messages  -->
      <div id="form-message" class="my-3 mt-3 d-flex justify-content-center"></div>

      <div class="w-100 text-center mt-5 d-none" id="backPage">
        <a href="javascript:history.back(1)" class="btn-fill ">Retourner liste avis</a>
      </div>

      <div class="connection-wrapper">

        <form method="POST" id="modifyReview">
          <div class="connection-form">
            <div class="form-group">
              <label for="client">Nom client</label>
              <input type="text" name="client" id="client" minlength="5" maxlength="45" placeholder="Dupont Jean-Charles" autocomplete="off" value="<?= htmlspecialchars($review['client']); ?>">
              <span class="error" id="client_err"> </span>
            </div>
            <div class="form-group">
              <label for="comment">Commentaire</label>
              <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="15" maxlength="250"> <?= htmlspecialchars($review['comment']); ?></textarea>
              <span class="error" id="comment_err"> </span>
            </div>

            <div class="form-group">
              <label for="note">Note client
              </label>
              <select name="note" id="note" class="form-control note">
                <option value="">Valeur actuel: <?= htmlspecialchars($review['note']); ?></option>
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
            <button type="button" id="submitbtn" class="btn-fill">Modifier</button>
          </div>
        </form>
      </div>

    <?php else : ?>
      <div id="form-message" class="d-flex justify-content-center">
        <div class='d-flex justify-content-center  alert alert-danger mt-5 mb-3 mx-auto' role='alert'>Cette avis
          n'existe
          pas</div>
      </div>


      <div class="go-back-page my-3 d-flex justify-content-center">
        <a href="javascript:history.back(1)" class="btn-wire mb-5">Retourner liste avis</a>
      </div>

    <?php endif ?>


  </section>
</div>
<script src="../assets/scripts/modifyReviewForm.js"></script>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>