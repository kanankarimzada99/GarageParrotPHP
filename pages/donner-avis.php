<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/../lib/starRating.php";
require_once __DIR__ . "/../templates/header-navigation.php";


$_SESSION['token'] = bin2hex(random_bytes(30));

$id = null;
?>

<div class="wrapper">

  <!-- BREADCRUMB  -->
  <div class="breadcrumbs breadcrumbs-connection">
    <div class="go-back-list">
      <a href="/">Revenir page accueil</a>
    </div>
  </div>
  <!-- END BREADCRUMB  -->

  <!-- connection  -->
  <section class="contact contact-buy-car sections" id="contact">
    <h1 class="header-titles">Donner votre avis</h1>

    <!-- messages  -->
    <div id="form-message" class="my-3 mt-3 d-flex justify-content-center"></div>

    <div class="contact-wrapper">
      <p class="text-center active">Votre avis est très important pour nous.</p>

      <form method="POST" id="addReview">

        <div class="connection-form">
          <div class="form-group">
            <label for="client">Votre nom</label>
            <input type="text" name="client" id="client" minlength="5" maxlength="50" placeholder="Dupont Jean-Charles" autocomplete="off">
            <span class="error" id="client_err"> </span>
          </div>
          <div class="form-group">
            <label for="comment">Votre commentaire</label>
            <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="15" maxlength="250"> </textarea>
            <span class="error" id="comment_err"> </span>
          </div>

          <div class="form-group">
            <label for="note">Votre note</label>
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
          <button type="button" id="submitbtn" class="btn-fill">Envoyez</button>
        </div>
      </form>
    </div>
  </section>
</div>
<script src="/../assets/scripts/validationReviewClient.js"></script>

<?php
require_once __DIR__ . "/../templates/footer.php";
?>