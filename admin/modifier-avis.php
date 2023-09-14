<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";

$errors = '';

$formReview = [
  'client' => '',
  'comment' => '',
  'note' => ''
];
$id = null;

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $_SESSION['review']['id'] = $id;

  $review = getReviewsById($pdo, $id);

  if ($review === false) {
    $errors =  "<div class='alert alert-danger m-0' role='alert'>Cette avis n'existe pas</div>";
  }
}
?>

<!-- send message by form  -->
<script>
  $(document).ready(function() {
    $("form").submit(function(event) {
      event.preventDefault();
      var client = $("#client").val();
      var comment = $("#comment").val();
      var note = $("#note").val();
      var submit = $("#submit").val();

      $(".form-message").load('modifierAvisForm.php', {
        client: client,
        name: name,
        comment: comment,
        note: note,
        submit: submit
      });
    })
  })
</script>

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

    <!-- messages  -->
    <div class="form-message">
      <?= $errors; ?>
    </div>

    <?php if ($formReview !== false) { ?>
      <div class="connection-wrapper">

        <form action="modifierAvisForm.php" method="POST">
          <div class="connection-form">
            <div class="form-group">
              <label for="client">Nom client</label>
              <input type="text" name="client" id="client" minlength="3" maxlength="50" placeholder="Dupont Jean-Charles" autocomplete="off" value="<?= htmlspecialchars($review['client'] ?? $formReview['client']); ?>">
            </div>
            <div class="form-group">
              <label for="comment">Commentaire</label>
              <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="5" maxlength="300"> <?= htmlspecialchars($review['comment'] ?? $formReview['comment']); ?></textarea>
            </div>

            <div class="form-group">
              <label for="note">Note client
              </label>
              <select name="note" id="note" class="form-control note">
                <option value="">Valeur actuel: <?= htmlspecialchars($review['note'] ?? $formReview['note']); ?></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
            </div>
          </div>
          <div class="form-btn">
            <button type="submit" value="add-review" id="submit" name="submit" class="btn-fill">Modifier</button>
          </div>
        </form>
      </div>
  </section>
</div>
<?php } else { ?>
  <div class="not-found">
    <!-- <h1 class="not-found-text">Employé non trouvé</h1> -->
    <div class="go-back-page">
      <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
    </div>
  </div>
<?php } ?>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>