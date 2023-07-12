<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/tools.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/templates/header-admin.php";

$id=null;
$errors = [];
$messages = [];
$formReview = [
  'client' => '',
  'comment' => '',
  'note'=>''
];


//regex
$regexClient = '/^\w.{3,50}$/';
$regexComment = '/^\w.{20,250}$/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  //verify errors inside the form

  //to validate nom client
  if (empty($_POST['client'])) {
    $errors[] = "Le nom du client est requis.";
  } elseif (!preg_match($regexClient, $_POST['client'])) {
    $errors[] = "Le nom du client doit contenir uniquement des lettres et espaces et avoir une longueur maximale de 50 caractères.";
  }
  //to validate comment client
  if (empty($_POST['comment'])) {
    $errors[] = "Le commentaire est requis.";
  } elseif (!preg_match($regexComment, $_POST['comment'])) {
    $errors[] = "Le commentaire doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.";
  }
  //to validate note
  if (empty($_POST['note']) || $_POST['note'] === '') {
    $errors[] = "La note est requis.";
  }

  //put information from form to formReview
  $formReview = [
    'client' => $_POST['client'],
    'description' => $_POST['comment'],
    'note'=>$_POST['note']
  ];

  //if no errors we save all information
  if (!$errors) {

    //all data will be saved at saveReview function

    $res = saveReview($pdo, $_POST["client"], $_POST["comment"], $_POST["note"], $id);

    if ($res) {
      $messages[] = "L'avis du client a bien été sauvegardé";

      //all information at formReview will be deleted
      if (!isset($_GET["id"])) {
        $formReview = [
          'client' => '',
          'description' => '',
          'note' => ''
        ];
      } else {
        $errors[] = "L'avis du client n'a pas été sauvegardé";
      }
    }
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
    <h1 class="header-titles">Ajouter avis client</h1>

    <!-- messages  -->
    <?php foreach ($messages as $message) { ?>
    <div class="alert alert-success mt-4" role="alert">
      <?= $message; ?>
    </div>
    <?php } ?>

    <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger mt-4" role="alert">
      <?= $error; ?>
    </div>
    <?php } ?>


    <?php if ($formReview !== false) { ?>
    <div class="connection-wrapper">

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="connection-form">
          <div class="form-group">
            <label for="client">Nom client</label>
            <input type="text" name="client" id="client" minlength="3" maxlength="50" placeholder="Dupont Jean-Charles">
          </div>
          <div class="form-group">
            <label for="comment">Commentaire</label>
            <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="5"
              maxlength="300"></textarea>
          </div>

          <div class="form-group">
            <label for="note">Note client</label>
            <select name="note" id="note">
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