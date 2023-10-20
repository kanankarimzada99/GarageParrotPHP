<?php
require_once __DIR__ . "/../lib/config.php";
require_once __DIR__ . "/../lib/session.php";
require_once __DIR__ . "/../lib/pdo.php";
require_once __DIR__ . "/../lib/cars.php";
require_once __DIR__ . "/../lib/services.php";
require_once __DIR__ . "/../lib/reviews.php";
require_once __DIR__ . "/../lib/starRating.php";
require_once __DIR__ . "/../templates/header-navigation.php";

$id = null;
// $errors = [];
// $messages = [];
// $formReview = [
//   'client' => '',
//   'comment' => '',
//   'note' => ''
// ];



// if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//   //verify errors inside the form

//   //to validate nom client
//   if (empty($_POST['client'])) {
//     $errors[] = "Votre nom est requis.";
//   } elseif (!preg_match(_REGEX_CLIENT_, $_POST['client'])) {
//     $errors[] = "Votre nom doit contenir uniquement des lettres et espaces et avoir une longueur maximale de 50 caractères.";
//   }
//   //to validate comment client
//   if (empty($_POST['comment'])) {
//     $errors[] = "Votre commentaire est requis.";
//   } elseif (!preg_match(_REGEX_COMMENT_, $_POST['comment'])) {
//     $errors[] = "Votre commentaire doit contenir uniquement des lettres, espaces et chiffres et avoir une longueur maximale de 200 caractères.";
//   }
//   //to validate note
//   if (empty($_POST['note']) || $_POST['note'] === '') {
//     $errors[] = "La note est requis.";
//   }

//   //put information from form to formReview
//   $formReview = [
//     'client' => $_POST['client'],
//     'comment' => $_POST['comment'],
//     'note' => $_POST['note']
//   ];

//   //if no errors we save all information
//   if (!$errors) {

//     //all data will be saved at saveReview function

//     $res = saveReview($pdo, $_POST["client"], $_POST["comment"], $_POST["note"], $id);

//     if ($res) {
//       $messages[] = "Votre avis a bien été sauvegardé";

//       //all information at formReview will be deleted
//       if (!isset($_GET["id"])) {
//         $formReview = [
//           'client' => '',
//           'comment' => '',
//           'note' => ''
//         ];
//       } else {
//         $errors[] = "Votre avis n'a pas été sauvegardé";
//       }
//     }
//   }
// }
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
    <div id="form-message" class="my-3 d-flex justify-content-center"></div>

    <div class="contact-wrapper">
      <p class="text-center active">Votre avis est très important pour nous.</p>

      <form method="POST" id="addReview">

        <div class="connection-form">
          <div class="form-group">
            <label for="client">Votre nom</label>
            <input type="text" name="client" id="client" minlength="3" maxlength="50" placeholder="Dupont Jean-Charles" autocomplete="off">
            <span class="error" id="client_err"> </span>
          </div>
          <div class="form-group">
            <label for="comment">Votre commentaire</label>
            <textarea name="comment" id="comment" class="comment" cols="30" rows="5" minlength="5" maxlength="300"> </textarea>
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
        <div class="form-btn">
          <button type="button" id="submitbtn" class="btn-fill">Ajouter</button>
        </div>
      </form>
    </div>
  </section>
</div>
<script src="/../assets/scripts/validationReviewClient.js"></script>

<?php
require_once __DIR__ . "/../templates/footer.php";
?>