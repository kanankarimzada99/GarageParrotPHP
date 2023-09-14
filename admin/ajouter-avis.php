<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";


$id = null;

$formReview = [
  'client' => '',
  'comment' => '',
  'note' => ''
];

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

      $(".form-message").load('ajouterAvisForm.php', {
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
    <h1 class="header-titles">Ajouter avis client</h1>

    <!-- messages  -->

    <div class="form-message">
    </div>

    <?php if ($formReview !== false) { ?>
      <div class="connection-wrapper">

        <form action="ajouterAvisForm.php" method="POST">

          <div class="connection-form">
            <div class="form-group">
              <label for="client">Nom client</label>
              <input type="text" name="client" id="client" minlength="3" maxlength="50" placeholder="Dupont Jean-Charles" autocomplete="off" value=<?= htmlspecialchars($formReview['client']); ?>>
            </div>
            <div class="form-group">
              <label for="comment">Commentaire</label>
              <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="5" maxlength="300"> <?= htmlspecialchars($formReview['comment']); ?></textarea>
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
            </div>
          </div>
          <div class="form-btn">
            <button type="submit" value="add-review" class="btn-fill">Ajouter</button>
          </div>
        </form>
      </div>
  </section>
</div>
<?php } else { ?>
  <div class="not-found">
    <div class="go-back-page">
      <a href="javascript:history.back(1)" class="btn-wire">Retour page précédante</a>
    </div>
  </div>
<?php } ?>

<?php
require_once __DIR__ . "/templates/footer-admin.php";
?>